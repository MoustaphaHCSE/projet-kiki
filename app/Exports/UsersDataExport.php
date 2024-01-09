<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $users;

    public function __construct()
    {
        $this->users = User::latest('id')->paginate(20);
    }

    public function view(): View
    {
        return view('users.index', [
            'users' => $this->users
        ]);
    }
}
