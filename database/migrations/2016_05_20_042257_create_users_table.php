<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->integer('mobile')->length(15);
            $table->string('address');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('job_skills')->comment="reference to job_skill table. multiple with comma.";
            $table->string('area_of_interest')->comment="reference to area_of_interest table. multiple with comma.";
            $table->string('role');
            $table->string('profile_pic')->nullable();
            $table->tinyInteger('loggedin');
            $table->string('paypal_email');
            $table->integer('activity_points')->nullable();
            $table->string('email_token')->nullable();
            $table->integer('is_email_verified')->default(0);
            $table->string('timezone')->nullable();
            $table->decimal('quality_of_work',8,2)->nullable();
            $table->decimal('timeliness',8,2)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
