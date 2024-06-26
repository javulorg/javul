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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');

            $table->unsignedBigInteger('objective_id')->nullable();
            $table->foreign('objective_id')->references('id')->on('objectives');

            $table->unsignedBigInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->bigInteger('category_id')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('comment')->nullable();
            $table->text('file_attachments')->nullable();

            $table->text('resolution')->nullable();
            $table->integer('verified_by')->nullable();
            $table->integer('resolved_by')->nullable();

//            $table->string('status')->comment('0 => Assigned to Task, 1 => Resolved');
            $table->tinyInteger('status')->comment('0 => Assigned to Task, 1 => Resolved');
            $table->tinyInteger('verified')->comment('0 => No, 1 => Yes')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
