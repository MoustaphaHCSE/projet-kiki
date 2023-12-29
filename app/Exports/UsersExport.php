<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class UsersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMappedCells
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return User::all();
    }

    public function headings(): array
    {
        return ["id", "Full name", "email", "Registered"];
    }

    public function mapping(): array
    {
        return [
            'name' => 'B1',
            'email' => 'B2',
        ];
    }
}
