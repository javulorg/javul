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
        Schema::create('objective_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('objective_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('name',255);
            $table->text('description')->nullable();
            $table->dateTime('created_time');
            $table->longText('comment')->nullable();
            $table->longText('size');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->dateTime('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objective_revisions');
    }
};
