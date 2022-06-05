<?php

namespace App\Imports;

use App\Models\Employee;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EmployeeImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['name'],
            'email' => $row['email'],
            'balance' => $row['balance'],
            'company_id' => $row['company_id'],
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
