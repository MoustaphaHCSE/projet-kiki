<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password} {roles}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new User';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $roles = $this->argument('roles');
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'roles' => $roles,
        ]);
        $this->info(sprintf('Success creating user: %s with the email %s.', $name, $email));
    }
}
