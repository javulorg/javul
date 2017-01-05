<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IssuesRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('objective_id');
            $table->integer('task_id');
            $table->string('title',255);
            $table->text('description');
            $table->text('resolution');
            $table->text('file_attachments');
            $table->string('status',255);
            $table->integer('verified_by');
            $table->integer('resolved_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');
            $table->integer('modified_by')->unsigned();
            $table->integer('size');
            $table->integer('issues_id');
            $table->string('comment',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issues_revisions');
    }
}
