<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class WikiPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_pages', function (Blueprint $table) {
            $table->increments('wiki_page_id');
            $table->integer('unit_id')->unsigned();
            $table->string('wiki_page_title',255);
            $table->text('page_content');
            $table->string('edit_comment',255);
            $table->integer('user_id')->unsigned();
            $table->integer('is_wikihome')->unsigned();
            $table->dateTime('time_stamp');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wiki_pages');
    }
}
