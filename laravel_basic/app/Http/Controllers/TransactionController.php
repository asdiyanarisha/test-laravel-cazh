<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;

use App\Http\Traits\QueryCompanies;
use App\Http\Traits\QueryEmployee;
use App\Http\Traits\QueryTransaction;


class TransactionController extends Controller
{
    use QueryCompanies;
    use QueryEmployee;
    use QueryTransaction;

    
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
        return view('transaction.add');
    }


    public function index()
    {
        return view('transaction.index', ['transactions' => $this->transaction_paginate(10)]);
    }

    public function insert(TransactionRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();

        $company = $this->query_company_by_id($data['company_id']);
        $employee = $this->query_employee_by_id($data['employee_id']);

        if ((int)$company['balance'] < (int)$data['balance']) {
            return response()->json(["msg" => "Company balance not sufficient"], 400);
        }

        $this->query_insert_transaction($data, $company, $employee);

        $this->update_balance_companies($company['id'], $company['balance'] - $data['balance']);

        $this->update_balance_employee($employee['id'], $employee['balance'] + $data['balance']);
        
        return response()->json(["msg" => "Sucessfully insert data"], 200);
    }
}
