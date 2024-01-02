<?php

namespace App\Exports;

use App\Models\Celebrity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CelebritiesExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Celebrity::all(['id', 'first_name', 'last_name', 'description', 'created_at']);
    }

    public function headings(): array
    {
        return ['id', 'prenom', 'nom', 'description', 'inscrit le'];
    }

    public function styles(Worksheet $sheet): void
    {
        $sheet->getStyle('E')->getFont()->setBold(true);
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->first_name,
            $row->last_name,
            $row->description,
            $row->created_at->format('Y-m-d'),
        ];
    }

}
