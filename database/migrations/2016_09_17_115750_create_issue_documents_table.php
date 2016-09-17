<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id')->unsigned();
            $table->foreign('issue_id')->references('id')->on('issues');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issue_documents');
    }
}
