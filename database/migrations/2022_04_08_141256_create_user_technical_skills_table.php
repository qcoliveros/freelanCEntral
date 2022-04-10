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
        Schema::create('user_technical_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('skill_id');
            $table->foreignId('proficiency_id');
            $table->text('description', 2048)->nullable();
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
        Schema::dropIfExists('user_technical_skills');
    }
};
