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
use Spatie\Permission\Models\Role;
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
        $this->userService->displayUsers();
        return view('users.index', [
            'users' => User::latest('id')->paginate(4)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->store($request->all());
        return redirect()->route('users.index')
            ->with('success', 'Nouvel utilisateur ajouté.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->userService->create();
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $this->userService->show($user);
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->userService->edit($user);
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($request->all(), $user);
        return redirect()->route('users.index')
            ->with('success', 'User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Check if user is Super Admin or deleted user is auth'ed user
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'CAN\'T DELETE THIS USER (it\'s either you or an admin');
        }
        $this->userService->destroy($user);
        return redirect()->route('users.index')
            ->with('success', 'User is deleted successfully.');
    }

    public function viewPDF(): Response
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
