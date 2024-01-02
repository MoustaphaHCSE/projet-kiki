<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MovieController extends Controller
{
    public function exportCSV(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users-list.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
