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
        Schema::create('gig_playbook_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_playbook_id');
            $table->foreignId('reviewer_id');
            $table->foreignId('reviewee_id');
            $table->text('review')->nullable();
            $table->date('review_date')->nullable();
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
        Schema::dropIfExists('gig_playbook_reviews');
    }
};
