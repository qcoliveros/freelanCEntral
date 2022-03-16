<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'code' => 'ADMIN', 'name' => 'Administrator'
        ]);
        Role::create([
            'code' => 'GIGGER', 'name' => 'Gigger'
        ]);
        Role::create([
            'code' => 'GIGHOST', 'name' => 'Gig Host'
        ]);
    }
}
