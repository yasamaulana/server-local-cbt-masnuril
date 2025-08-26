<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PendaftarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Pendaftaran::query();

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . request('q') . '%')
                    ->orWhere('nisn', 'like', '%' . request('q') . '%')
                    ->orWhere('nik', 'like', '%' . request('q') . '%');
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('tahun')) {
            $query->whereYear('created_at', request('tahun'));
        }

        return $query->select(
            'nama',
            'nik',
            'nisn',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'asal_sekolah',
            'alamat',
            'no_hp',
            'nama_ayah',
            'alamat_ayah',
            'nik_ayah',
            'pekerjaan_ayah',
            'nama_ibu',
            'alamat_ibu',
            'nik_ibu',
            'pekerjaan_ibu',
            'kk',
            'ktp_ayah',
            'ktp_ibu',
            'kip',
            'kks',
            'ijazah',
            'rekomendasi',
            'status',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Asal Sekolah',
            'Alamat',
            'No HP',
            'Nama Ayah',
            'Alamat Ayah',
            'NIK Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'Alamat Ibu',
            'NIK Ibu',
            'Pekerjaan Ibu',
            'No KK',
            'KTP Ayah',
            'KTP Ibu',
            'KIP',
            'KKS',
            'Ijazah',
            'Rekomendasi',
            'Status',
            'Tanggal Daftar'
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B'  => NumberFormat::FORMAT_TEXT, // NIK
            'M'  => NumberFormat::FORMAT_TEXT, // NIK Ayah
            'Q'  => NumberFormat::FORMAT_TEXT, // NIK Ibu
            'S'  => NumberFormat::FORMAT_TEXT, // KK
            'T'  => NumberFormat::FORMAT_TEXT, // KTP Ayah
            'U'  => NumberFormat::FORMAT_TEXT, // KTP Ibu
        ];
    }
}
