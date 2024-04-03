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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title_type')->nullable();
            $table->tinyInteger('resource_type')->comment('1=>task')->default(1);
            $table->tinyInteger('action_type')->comment('1 => Accept & Reject')->default(1);
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('user_id');
            $table->boolean('is_read')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
