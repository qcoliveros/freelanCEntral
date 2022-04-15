<?php

namespace Database\Seeders;

use App\Models\Parameter\Duration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Duration::create(['name' => 'Day(s)']);
        Duration::create(['name' => 'Week(s)']);
        Duration::create(['name' => 'Month(s)']);
        Duration::create(['name' => 'Year(s)']);
    }
}
