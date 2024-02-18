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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');

            $table->foreignId('unit_id')->constrained('units');

            $table->foreignId('task_id')->nullable()->constrained('tasks');

            $table->foreignId('issue_id')->nullable()->constrained('issues');

            $table->bigInteger('category_id')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('comment')->nullable();
            $table->string('file')->nullable();
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
