<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class UserwikiRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userwiki_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('page_title',255);
            $table->text('page_content');
            $table->string('comment',255);
            $table->string('slug',30);
            $table->tinyInteger('private');
            $table->integer('size')->unsigned();
            $table->integer('modify_by')->unsigned();
            $table->integer('page_type')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('userwiki_revisions');
    }
}
