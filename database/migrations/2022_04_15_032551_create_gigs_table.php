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
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_host_id');
            // job details
            $table->string('job_title');
            $table->text('description', 2048);
            $table->foreignId('job_function');
            $table->string('other_job_function');
            $table->integer('commitment_time');
            $table->foreignId('commitment_duration');
            $table->date('job_start_date');
            $table->date('job_end_date');
            // posting details
            $table->date('posted_date');
            $table->boolean('is_draft')->nullable();
            $table->boolean('is_post_end')->nullable();
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
        Schema::dropIfExists('gigs');
    }
};
