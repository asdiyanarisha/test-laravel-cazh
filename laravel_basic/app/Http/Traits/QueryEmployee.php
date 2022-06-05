<?php
namespace App\Http\Traits;

use App\Models\Employee;

trait QueryEmployee {

    public function query_insert_employee($data) {

        $employee = new Employee;
        
        $employee->name = $data['name'];
        $employee->balance = $data['balance'];
        $employee->email = $data['email'];
        $employee->company_id = $data['company_id'];

        $employee->save();
    }

    public function query_track_name_employee($name)
    {
        return Employee::where('name', $name)->first();
    }

    public function employee_paginate($count)
    {
        $data = Employee::paginate($count);
        return $data;
    }

    public function query_employee_by_id($id)
    {
        return Employee::where('id', $id)->first();
    }

    public function query_employee_by_company_id($id)
    {
        return Employee::where('company_id', $id)->get();
    }

    public function delete_employee($id) {

        $employee = Employee::where('id', $id);
        
        $employee->delete();
    }

    public function update_employee($data) {

        $employee = Employee::where('id', $data['id'])->first();
        
        $employee->name = $data['name'];
        $employee->balance = $data['balance'];
        $employee->email = $data['email'];
        $employee->company_id = $data['company_id'];

        $employee->save();
    }


    public function query_employee_paginate($request)
    {
        $q = $request->q;
        $employee = Employee::where('company_id', $q['company_id']);
        $employee = $q['term'] ? Employee::where('name', 'LIKE', $q['term']) : $employee;
        return $employee->paginate(10, ['*'], 'page', $request->page)->toArray();
    }

    public function update_balance_employee($id, $balance) {

        $company = Employee::where('id', $id)->first();
        
        $company->balance = $balance;

        $company->save();
    }

}