<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Traits\HasRoles;

class UpdateUserRoleCommand extends Command
{
    use HasRoles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update {--id=} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user role with id';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $id = $this->option('id');
        $role = $this->option('role');
        $user = User::where('id', $id)->first();
        $user->syncRoles($role);
    }
}
