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
        Schema::create('gig_playbook_task_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_playbook_task_id');
            $table->foreignId('gig_playbook_task_comment_id')->nullable();
            $table->foreignId('user_id');
            $table->text('message');
            $table->date('publish_date');
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
        Schema::dropIfExists('gig_playbook_task_comments');
    }
};
