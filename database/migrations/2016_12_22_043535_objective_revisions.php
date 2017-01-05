<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ObjectiveRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objective_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('objective_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('name',255);
            $table->text('description');
            $table->dateTime('created_time');
            $table->longText('comment',255);
            $table->longText('size',10);
            $table->integer('parent_id')->unsigned();
            $table->integer('modified_by')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('objective_revisions');
    }
}
