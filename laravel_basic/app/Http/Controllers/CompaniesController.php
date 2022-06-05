<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Requests\CompaniesInsertRequest;
use App\Http\Requests\CompaniesEditRequest;

use App\Http\Traits\QueryCompanies;
use App\Http\Traits\QueryEmployee;

class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    use QueryCompanies;
    use QueryEmployee;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('companies.add');
    }

    public function index()
    {
        return view('companies.index', ['companies' => $this->company_paginate(5)]);
    }

    public function edit($id)
    {
        return view('companies.edit', ['company' => $this->query_company_by_id($id)]);
    }
    
    public function insert(CompaniesInsertRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();

        if ($this->query_track_name_company($data['name'])) {
            $err_response = ['message' => 'Name already tracked', 'errors' => ['name' => ['Name company `'.$data['name'].'` already taken']]];
            abort(response()->json($err_response, 422));
        }

        $data['path_logo'] = $this->process_image($request, $data['name']);

        $this->query_insert_companies($data);
        
        return response()->json(["msg" => "Sucessfully insert data"], 200);
    }

    public function change(CompaniesEditRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();

        $old_data = $this->query_company_by_id($data['id']);
        if ($old_data['name'] != $data['name']) {
            if ($this->query_track_name_company($data['name'])) {
                $err_response = ['message' => 'Name already tracked', 'errors' => ['name' => ['Name company `'.$data['name'].'` already taken']]];
                abort(response()->json($err_response, 422));
            }
        }

        $data['path_logo'] = $old_data['logo'];
        if ($request->hasFile('logo')) {
            $this->remove_image($old_data['logo']);
            $data['path_logo'] = $this->process_image($request, $data['name']);
        }

        $this->update_companies($data);
        
        return response()->json(["msg" => "Sucessfully edited data"], 200);
    }

    public function delete(Request $request)
    {
        $old_data = $this->query_company_by_id($request->id);
        $this->remove_image($old_data['logo']);
        $this->delete_companies($request->id);
        return response()->json(["msg" => "Sucessfully deleted data"], 200);
    }

    public function paginate(Request $request)
    {
        return $this->query_company_paginate($request);
    }

    public function pdf($id)
    {
        $company = $this->query_company_by_id($id);
        $employees = $this->query_employee_by_company_id($id);

        $pdf = PDF::loadView('pdf.employee', ['company' => $company, "employees" => $employees]);
        return $pdf->download('employee.pdf');
    }

    function process_image($request, $name)
    {
        $logo = $request->file('logo');
        $ext = $request->file('logo')->extension();

        $file_name = str_replace(' ', '_', strtolower($name)).".".$ext;

        
        $ext = $request->file('logo')->storeAs('company', $file_name);

        return $file_name;
    }

    function remove_image($path)
    {
        Storage::disk('company')->delete($path);
    }
}
