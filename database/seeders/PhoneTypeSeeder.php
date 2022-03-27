<?php

namespace Database\Seeders;

use App\Models\Parameter\PhoneType;
use Illuminate\Database\Seeder;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneType::create(['name' => 'Home']);
        PhoneType::create(['name' => 'Mobile']);
        PhoneType::create(['name' => 'Work']);
    }
}
