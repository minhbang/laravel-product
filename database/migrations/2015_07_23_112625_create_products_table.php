<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'products',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('slug', 255)->unique();
                $table->longText('description');
                $table->integer('price');
                $table->integer('price_old')->nullable();
                $table->string('code', 100)->unique();
                $table->string('size', 255)->nullable();
                $table->integer('gender')->unsigned()->default(0);
                $table->integer('hit')->unsigned()->default(0);
                $table->integer('user_id')->unsigned();
                $table->integer('category_id')->unsigned()->nullable();
                $table->integer('age_id')->unsigned()->nullable();
                $table->integer('manufacturer_id')->unsigned()->nullable();
                $table->string('featured_image', 255);
                $table->integer('position')->unsigned()->default(0);
                $table->boolean('is_special')->default(false);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
