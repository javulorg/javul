<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_topic_updown', function (Blueprint $table) {
//            $table->id();
            $table->increments('topic_id');
            $table->foreignId('user_id')->constrained('users');
            $table->tinyInteger('value');
            $table->dateTime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_topic_updown');
    }
};
