<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product_translations',
            function (Blueprint $table) {
                $table->increments('id');

                $table->string('name', 255);
                $table->string('slug', 255);
                $table->longText('description');

                $table->integer('product_id')->unsigned();
                $table->string('locale', '10')->index();
                $table->unique(['product_id', 'locale']);
                $table->unique(['slug', 'locale']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::drop('product_translations');
    }
}
