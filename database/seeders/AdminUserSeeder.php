<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@sproutacademy.com';

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin User',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // Default password - should be changed
                'remember_token' => Str::random(10),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: ' . $email);
            $this->command->info('Password: admin123');
            $this->command->warn('Please change the default password after first login!');
        } else {
            $this->command->info('Admin user already exists with email: ' . $email);
        }
    }
}
