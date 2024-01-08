<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
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
    protected $signature = 'user:create {--count=}';

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
        $count = $this->option('count');

        $bar = $this->output->createProgressBar($count);
        $bar->start();
        for ($i = 1; $i <= $count; $i++) {
//            $name = $this->argument('name');
//            $email = $this->argument('email');
//            $password = $this->argument('password') ?? Hash::make('password');
            $name = fake()->name();
            $mail = preg_replace('/[^a-z]/', '', strtolower($name));
            User::create([
                'name' => $name,
                'email' => $mail . '@gmail.com',
                'password' => Hash::make('password'),
            ])->assignRole(RoleEnum::USER);
            $this->info(sprintf(' Success creating user: %s and his email %s.', $name, $mail));
            $bar->advance();
        }
        $bar->finish();
    }
}
