<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('unit_type')->nullable()->comment('0 => product, 1 => service, 2 => Peoples Government');
            $table->string('product_name')->nullable();
            $table->string('service_name')->nullable();
            $table->tinyInteger('business_model')->nullable()->comment('0=> Community-owned, 1=> Corporate');
            $table->string('operational_grade')->nullable();
            $table->string('company')->nullable();
            $table->tinyInteger('scope')->nullable()->comment('0=> City,1=> County,2=> State,3=> National,4=> International');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('category_id')->comment('reference to unit_category. multiple categories with comma.');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('comment')->nullable();
            $table->string('credibility')->comment('platinum,gold,silver or bronze');
            $table->unsignedBigInteger('country_id')->nullable();

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->string('status')->comment("active or disabled");
            $table->integer('parent_id')->nullable();
            $table->integer('modified_by')->nullable();
            $table->tinyInteger('featured_unit')->default(0);
            $table->text('state_id_for_city_not_exits')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
