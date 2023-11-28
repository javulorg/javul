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
        Schema::create('importance_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('objective_id')->nullable()->constrained('objectives');
            $table->foreignId('issue_id')->nullable()->constrained('issues');

            $table->string('importance_level')->nullable();
            $table->integer('importance_upvote')->nullable();
            $table->integer('importance_downvote')->nullable();
            $table->string('type')->nullable()->comment('objective or issue');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importance_level');
    }
};
