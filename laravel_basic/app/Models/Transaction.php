<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';

    

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
