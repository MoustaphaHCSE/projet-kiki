<?php

namespace App\Exports;

use App\Models\Movie;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MoviesExport implements FromCollection, WithHeadings, WithStyles, WithMapping, ShouldAutoSize
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Movie::all(['title', 'created_at']);
    }

    public function headings(): array
    {
        return ['Titre', 'Ajouté le'];

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A')->getfont()->setBold(true)->setItalic(true);
    }

    public function map($row): array
    {
        return [
            $row->title,
            $row->created_at->format('Y-m-d')
        ];
    }
}
