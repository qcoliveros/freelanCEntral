<?php

namespace Database\Seeders;

use App\Models\Parameter\JobFunction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobFunction::create(['name' => 'Accounting / Auditing']);
        JobFunction::create(['name' => 'Administrative']);
        JobFunction::create(['name' => 'Advertising']);
        JobFunction::create(['name' => 'Analyst']);
        JobFunction::create(['name' => 'Art / Creative']);
        JobFunction::create(['name' => 'Business Development']);
        JobFunction::create(['name' => 'Consulting']);
        JobFunction::create(['name' => 'Customer Service']);
        JobFunction::create(['name' => 'Distribution']);
        JobFunction::create(['name' => 'Design']);
        JobFunction::create(['name' => 'Education']);
        JobFunction::create(['name' => 'Engineering']);
        JobFunction::create(['name' => 'Finance']);
        JobFunction::create(['name' => 'General Business']);
        JobFunction::create(['name' => 'HealthCare Provider']);
        JobFunction::create(['name' => 'Human Resources']);
        JobFunction::create(['name' => 'Information Technology']);
        JobFunction::create(['name' => 'Legal']);
        JobFunction::create(['name' => 'Management']);
        JobFunction::create(['name' => 'Manufacturing']);
        JobFunction::create(['name' => 'Marketing']);
        JobFunction::create(['name' => 'Other']);
        JobFunction::create(['name' => 'Public Relations']);
        JobFunction::create(['name' => 'Purchasing']);
        JobFunction::create(['name' => 'Product Management']);
        JobFunction::create(['name' => 'Project Management']);
        JobFunction::create(['name' => 'Production']);
        JobFunction::create(['name' => 'QualityAssurance']);
        JobFunction::create(['name' => 'Research']);
        JobFunction::create(['name' => 'Sales']);
        JobFunction::create(['name' => 'Science']);
        JobFunction::create(['name' => 'Strategy / Planning']);
        JobFunction::create(['name' => 'Supply Chain']);
        JobFunction::create(['name' => 'Training']);
        JobFunction::create(['name' => 'Writing / Editing']);
    }
}
