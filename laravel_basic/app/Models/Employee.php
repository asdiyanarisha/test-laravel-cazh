<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\Company;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $fillable = ['name', 'email', 'balance', 'company_id'];


    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
