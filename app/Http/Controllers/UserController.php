<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Service\UserService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return $this->userService->displayUsers();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        return $this->userService->store($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->userService->create();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return $this->userService->show($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return $this->userService->edit($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        return $this->userService->update($request->all(), $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        return $this->userService->destroy($user);
    }

    public function viewPDF()
    {
        $users = User::latest('id')->paginate(20);
        $pdf = Pdf::loadView('users.index', array('users' => $users))
            ->setPaper('a4');

        return $pdf->stream();
    }

    public function downloadPDF(): Response
    {
        $users = User::latest('id')->paginate(20);
        $pdf = Pdf::loadView('users.index', array('users' => $users))
            ->setPaper('a4');

        return $pdf->download('users-export.pdf');
    }

    public function exportCSV(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users-list.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
