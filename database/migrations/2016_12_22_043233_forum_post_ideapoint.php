<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ForumPostIdeapoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_post_ideapoint', function (Blueprint $table) {
            
            $table->integer('topic_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('value')->unsigned();
            $table->dateTime('created_time');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_post_ideapoint');
    }
}
