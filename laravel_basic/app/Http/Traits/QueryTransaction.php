<?php
namespace App\Http\Traits;

use App\Models\Transaction;

trait QueryTransaction {

    public function query_insert_transaction($param, $company, $employee)
    {
        $transaction = new Transaction;
        
        $transaction->company_id = $param['company_id'];
        $transaction->employee_id = $param['employee_id'];
        $transaction->balance = $param['balance'];
        $transaction->company_start_balance = $company['balance'];
        $transaction->company_last_balance = $company['balance'] - $param['balance'];
        $transaction->employee_start_balance = $employee['balance'];
        $transaction->employee_last_balance = $employee['balance'] + $param['balance'];

        $transaction->save();
    }

    public function transaction_paginate($count)
    {
        $data = Transaction::paginate($count);
        return $data;
    }
}