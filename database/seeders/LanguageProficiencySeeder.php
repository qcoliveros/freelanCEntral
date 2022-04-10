<?php

namespace Database\Seeders;

use App\Models\Parameter\LanguageProficiency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageProficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LanguageProficiency::create(['name' => 'Beginner']);
        LanguageProficiency::create(['name' => 'Intermediate']);
        LanguageProficiency::create(['name' => 'Fluent']);
        LanguageProficiency::create(['name' => 'Native']);
    }
}
