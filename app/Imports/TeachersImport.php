<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;

class TeachersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Teacher([
            'name'          => $row['name'],
            'email'         => $row['email'],
            'gender'        => $row['gender'],
            'address'       => $row['address'],
            'position'      => $row['position'],
        ]);
    }
}
