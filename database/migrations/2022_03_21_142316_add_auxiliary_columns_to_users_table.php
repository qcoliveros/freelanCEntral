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
        Schema::table('users', function (Blueprint $table) {
            $table->after('profile_photo_path', function ($table) {
                $table->string('phone')->unique()->nullable();
                $table->foreignId('phone_type')->nullable();
                $table->string('messenger')->unique()->nullable();
                $table->foreignId('messenger_type')->nullable();
                $table->string('website_url', 2048)->nullable();
                $table->text('about')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
