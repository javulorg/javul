<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('forum_topic', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('topic_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('desc')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('unit_id')->nullable()->constrained('units');
            $table->string('slug')->nullable();
            $table->bigInteger('section_id')->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->timestamp('modify_time')->nullable();
            $table->dateTime('created_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_topic');
    }
};
