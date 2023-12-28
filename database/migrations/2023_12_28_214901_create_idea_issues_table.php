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
        Schema::create('idea_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_id')->nullable()->constrained('ideas');
            $table->foreignId('issue_id')->nullable()->constrained('issues');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_issues');
    }
};
