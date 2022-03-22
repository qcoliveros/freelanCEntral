<?php

namespace Database\Seeders;

use App\Models\Proficiency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proficiency::create(['name' => 'Beginner']);
        Proficiency::create(['name' => 'Intermediate']);
        Proficiency::create(['name' => 'Advanced']);
    }
}
