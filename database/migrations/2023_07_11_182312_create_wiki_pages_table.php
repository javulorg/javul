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
        Schema::create('wiki_pages', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_unit_page')->default(0);
            $table->integer('wiki_page_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->string('wiki_page_title',255);
            $table->text('page_content');
            $table->string('edit_comment',255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('is_wikihome');
            $table->dateTime('time_stamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wiki_pages');
    }
};
