<?php

namespace Database\Seeders;

use App\Models\Parameter\SkillProficiency;
use Illuminate\Database\Seeder;

class SkillProficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SkillProficiency::create(['name' => 'Beginner']);
        SkillProficiency::create(['name' => 'Intermediate']);
        SkillProficiency::create(['name' => 'Advanced']);
    }
}
