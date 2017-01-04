<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ChatRoom extends Migration
{
    /**
     * /Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chat_room', function (Blueprint $table) {
            $table->increments('room_id');
            $table->string('name');
            $table->integer('unit_id')->unsigned();
            $table->integer('total_member')->unsigned();
            $table->dateTime('created_datetime');
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
         Schema::drop('chat_room');
    }
}
