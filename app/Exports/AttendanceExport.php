<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    protected $attendance;
    protected $month;
    protected $classroomTitle;

    public function __construct($attendance, $month, $classroomTitle)
    {
        $this->attendance = $attendance;
        $this->month = $month;
        $this->classroomTitle = $classroomTitle;
    }

    public function collection()
    {
        return collect($this->attendance);
    }

    public function map($row): array
    {
        $daysInMonth = Carbon::parse($this->month)->daysInMonth;
        $mapped = [$row['name']];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $mapped[] = $row['attendance'][$day] ?? '';
        }
        return $mapped;
    }

    public function headings(): array
    {
        $daysInMonth = Carbon::parse($this->month)->daysInMonth;
        $headings = ['Nama'];
        for ($day = 1; $day <= $daysInMonth; $headings[] = $day++);
        return [
            ["Laporan Absensi Kelas: {$this->classroomTitle}, Bulan: {$this->month}"],
            $headings,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '2')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}