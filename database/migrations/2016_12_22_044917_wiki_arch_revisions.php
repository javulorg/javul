<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class WikiArchRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_arch_revisions', function (Blueprint $table) {
            $table->increments('revision_id');
            $table->integer('unit_id')->unsigned();
            $table->integer('wiki_page_id')->unsigned();
            $table->text('rev_page_content');
            $table->string('change_byte',255);
            $table->string('edit_comment',255);
            $table->integer('user_id')->unsigned();
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
        Schema::drop('wiki_arch_revisions');
    }
}
