<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'manufacturers',
            function ($table) {
                $table->increments('id');
                $table->string('name', 128);
                $table->string('slug', 128)->unique();
                $table->string('logo', 255);
                $table->integer('position')->unsigned()->default(0);
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
        Schema::drop('manufacturers');
    }
}
