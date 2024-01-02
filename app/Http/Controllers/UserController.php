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
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Log::channel('user-crud')->info('displaying all users');

        return view('users.index', [
            'users' => User::latest('id')->paginate(3)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->store($request->all());
        Log::channel('user-crud')->info('Adding a new user');

        return redirect()->route('users.index')
            ->with('success', 'New user is added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Log::channel('user-crud')->info('Creating a User');
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        Log::channel('user-crud')->info(sprintf('Showing user: %s \'s profile', $user->id));
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

        Log::channel('user-crud')->info(sprintf('User: %s\'s profile is being edited', $user->id));
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

        Log::channel('user-crud')->info(sprintf('Update on user: %s', $user->id));
        return redirect()->back()
            ->with('success', 'User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->userService->destroy($user);

        Log::channel('user-crud')->info(sprintf('Delete user: %s', $user->id));
        return redirect()->route('users.index')
            ->with('success', 'User is deleted successfully.');
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
//        return Excel::download(new UsersDataExport, 'users-data.xlsx');
    }
}
