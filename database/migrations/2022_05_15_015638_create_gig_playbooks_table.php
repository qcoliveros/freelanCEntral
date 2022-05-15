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
        Schema::create('gig_playbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_host_id');
            $table->foreignId('gigger_id');
            $table->string('job_title');
            $table->date('job_start_date');
            $table->date('job_end_date');
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
        Schema::dropIfExists('gig_playbooks');
    }
};
