<?php

namespace App\Imports;

use App\Models\Prestasi;
use Maatwebsite\Excel\Concerns\ToModel;

class PrestasiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Prestasi([
            'judul'          => $row['judul'],
            'deskripsi'         => $row['deskripsi'],
        ]);
    }
}
