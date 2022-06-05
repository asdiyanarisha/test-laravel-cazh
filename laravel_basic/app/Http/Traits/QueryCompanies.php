<?php
namespace App\Http\Traits;

use App\Models\Company;

trait QueryCompanies {

    public function query_insert_companies($data) {

        $company = new Company;
        
        $company->name = $data['name'];
        $company->website = $data['website'];
        $company->balance = $data['balance'];
        $company->email = $data['email'];
        $company->logo = $data['path_logo'];

        $company->save();
    }

    public function company_paginate($count)
    {
        return Company::paginate($count);
    }

    public function query_track_name_company($name)
    {
        return Company::where('name', $name)->first();
    }

    public function query_company_by_id($id)
    {
        return Company::where('id', $id)->first();
    }

    public function delete_companies($id) {

        $company = Company::where('id', $id);
        
        $company->delete();
    }

    public function update_companies($data) {

        $company = Company::where('id', $data['id'])->first();
        
        $company->name = $data['name'];
        $company->website = $data['website'];
        $company->balance = $data['balance'];
        $company->email = $data['email'];
        $company->logo = $data['path_logo'];

        $company->save();
    }

    public function query_company_paginate($request)
    {
        $company = $request->search ? Company::where('name', 'LIKE', "%$request->search%") : new Company();
        return $company->paginate(10, ['*'], 'page', $request->page)->toArray();
    }

    public function update_balance_companies($id, $balance) {

        $company = Company::where('id', $id)->first();
        
        $company->balance = $balance;

        $company->save();
    }

}
