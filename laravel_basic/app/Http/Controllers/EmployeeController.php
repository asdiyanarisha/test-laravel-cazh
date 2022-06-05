<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\EmployeeImport;
use App\Http\Requests\EmployeeInsertRequest;
use App\Http\Requests\EmployeeEditRequest;

use App\Http\Traits\QueryEmployee;

class EmployeeController extends Controller
{
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
        return view('employees.add');
    }

    public function import()
    {
        return view('employees.import');
    }

    public function edit($id)
    {
        return view('employees.edit', ['employee' => $this->query_employee_by_id($id)]);
    }

    public function insert(EmployeeInsertRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();

        if ($this->query_track_name_employee($data['name'])) {
            $err_response = ['message' => 'Name already tracked', 'errors' => ['name' => ['Name employee `'.$data['name'].'` already taken']]];
            abort(response()->json($err_response, 422));
        }

        $this->query_insert_employee($data);
        
        return response()->json(["msg" => "Sucessfully insert data"], 200);
    }

    public function delete(Request $request)
    {
        $old_data = $this->query_employee_by_id($request->id);
        $this->delete_employee($request->id);
        return response()->json(["msg" => "Sucessfully deleted data"], 200);
    }


    public function index()
    {
        return view('employees.index', ['employees' => $this->employee_paginate(10)]);
    }

    public function change(EmployeeEditRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();

        $old_data = $this->query_employee_by_id($data['id']);
        if ($old_data['name'] != $data['name']) {
            if ($this->query_track_name_employee($data['name'])) {
                $err_response = ['message' => 'Name already tracked', 'errors' => ['name' => ['Name company `'.$data['name'].'` already taken']]];
                abort(response()->json($err_response, 422));
            }
        }

        $this->update_employee($data);
        
        return response()->json(["msg" => "Sucessfully edited data"], 200);
    }

    public function upload(Request $request) 
    {
        Excel::import(new EmployeeImport, $request->file('file'));
        
        return redirect('/')->with('success', 'All good!');
    }


    public function paginate(Request $request)
    {
        return $this->query_employee_paginate($request);
    }
}
