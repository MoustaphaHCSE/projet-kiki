<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Log::channel('role-crud')->info('displaying all roles');

        return view('roles.index', [
            'roles' => Role::orderBy('id', 'DESC')->paginate(3)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        Log::channel('role-crud')->info('adding roles');

        return redirect()->route('roles.index')
            ->with('success', 'Nouveau rôle ajouté.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Log::channel('role-crud')->info('creating a role');

        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $role->id)
            ->select('name')
            ->get();

        Log::channel('role-crud')->info(sprintf('displaying role %s', $role->name));

        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'TU PEUX PAS ÉDITER LE ROLE DU SUPER SAÏYAN ORIGINEL');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        Log::channel('role-crud')->info(sprintf('editing role %s', $role->name));

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        Log::channel('role-crud')->info(sprintf('updating role %s', $role->name));

        return redirect()->back()
            ->with('success', 'Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();

        Log::channel('role-crud')->info(sprintf('Deleting the %s role', $role->name));

        return redirect()->route('roles.index')
            ->with('success', 'Role is deleted successfully.');
    }
}
