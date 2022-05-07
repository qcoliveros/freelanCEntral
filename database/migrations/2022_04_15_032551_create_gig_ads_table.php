<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            // job details
            $table->string('job_title');
            $table->text('description', 2048);
            $table->foreignId('job_function_id');
            $table->string('other_job_function')->nullable();
            $table->integer('commitment_time');
            $table->foreignId('commitment_duration_id');
            $table->date('job_start_date');
            $table->date('job_end_date');
            // posting details
            $table->date('publish_date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gig_ads');
    }
};
