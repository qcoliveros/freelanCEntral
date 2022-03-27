<?php

namespace Database\Seeders;

use App\Models\Parameter\MessengerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessengerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MessengerType::create(['name' => 'Google Hangouts']);
        MessengerType::create(['name' => 'Skype']);
        MessengerType::create(['name' => 'WeChat']);
    }
}
