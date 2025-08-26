<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterserapan extends Model
{
    use HasFactory;

    protected $table = 'keterserapan';

    protected $fillable = [
        'program_keahlian',
        'jumlah_laki_laki',
        'jumlah_perempuan',
        'bekerja',
        'kuliah',
        'usaha',
        'jumlah',
    ];
}
