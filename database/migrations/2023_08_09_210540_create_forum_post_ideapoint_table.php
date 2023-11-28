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
        Schema::create('forum_post_ideapoint', function (Blueprint $table) {
//            $table->id();
            $table->increments('post_id');
            $table->integer('user_id')->unsigned();
            $table->integer('topic_id');
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
        Schema::dropIfExists('forum_post_ideapoint');
    }
};
