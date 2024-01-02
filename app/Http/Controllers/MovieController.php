<?php

namespace App\Http\Controllers;

use App\Exports\MoviesExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MovieController extends Controller
{
    public function exportCSV(): BinaryFileResponse
    {
        return Excel::download(new MoviesExport(), 'movies-list.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
