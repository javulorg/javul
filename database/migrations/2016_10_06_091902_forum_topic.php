<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ForumTopic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('forum_topic', function (Blueprint $table) {
            $table->increments('topic_id');
            $table->string('title',255);
            $table->text('desc');
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('slug',255);
            $table->integer('section_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->dateTime('created_time');
            $table->dateTime('modify_time');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_topic');
    }
}
