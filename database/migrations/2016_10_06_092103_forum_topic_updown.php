<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ForumTopicUpdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('forum_topic_updown', function (Blueprint $table) {
            $table->increments('topic_id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('value');
            $table->dateTime('datetime');
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
         Schema::drop('forum_topic_updown');
    }
}
