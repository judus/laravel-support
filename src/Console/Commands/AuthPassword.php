<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\User;

/**
 * Class AuthPassword
 *
 * @package Previon\Auth\Console\Commands
 */
class AuthPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets a password for a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($user = User::where('email', $this->argument('email'))->first()) {

            $password = $this->secret('Enter password:');
            $user->password = Hash::make($password);

            $user->save();

            $this->line('User password updated.');
        } else {
            $this->line('User not found.');
        }
    }
}
