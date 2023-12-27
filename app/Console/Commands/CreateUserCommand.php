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
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = fake()->name();
        $mail = preg_replace('/[^a-z]/', '', strtolower($name));
        User::create([
            'name' => $name,
            'email' => $mail . '@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $this->info('Success creating user : ' . $name);
    }
}
