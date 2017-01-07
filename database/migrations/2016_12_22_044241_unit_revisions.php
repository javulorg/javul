<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class UnitRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('category_id',255);
            $table->string('name',255);
            $table->text('description');
            $table->string('comment',255);
            $table->string('credibility',255);
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('status',255);
            $table->integer('parent_id')->unsigned();
            $table->integer('modified_by')->unsigned();
            $table->dateTime('created_at');
            $table->string('size',255);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unit_revisions');
    }
}
