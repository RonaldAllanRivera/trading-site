<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME', 'Admin');
        $email = env('ADMIN_EMAIL', 'jaeron.rivera@gmail.com');
        $password = env('ADMIN_PASSWORD', '123456');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                // The User model will hash this via the password cast
                'password' => $password,
                'is_admin' => true,
            ]
        );

        if (method_exists($this->command, 'info')) {
            $this->command->info(sprintf(
                'Admin user is ready. Email: %s | Password: %s | is_admin: %s',
                $email,
                $password,
                $user->is_admin ? 'true' : 'false'
            ));
        }

        // Additional seeded admin (explicit values)
        $tester = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Tester',
                'password' => '123456',
                'is_admin' => true,
            ]
        );

        if (method_exists($this->command, 'info')) {
            $this->command->info(sprintf(
                'Admin user is ready. Email: %s | Password: %s | is_admin: %s',
                $tester->email,
                '123456',
                $tester->is_admin ? 'true' : 'false'
            ));
        }
    }
}
