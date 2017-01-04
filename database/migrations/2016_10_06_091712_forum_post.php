<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ForumPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('forum_post', function (Blueprint $table) {
            $table->increments('post_id');
            $table->text('post');
            $table->integer('user_id')->unsigned();
            $table->integer('topic_id')->unsigned();
            $table->integer('replay_id')->unsigned();
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
        //
         Schema::drop('forum_post');
    }
}
