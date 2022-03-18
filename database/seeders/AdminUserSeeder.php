<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'freelancentral2022@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('P@44w0rd'),
            'role_id' => 1,
        ]);
    }
}
