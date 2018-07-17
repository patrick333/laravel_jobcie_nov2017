<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();

            $table->text('title');
            $table->text('description');
            $table->text('status')->default('NEW');
            $table->float('location_lat');
            $table->float('location_long');
            $table->float('price')->default(0);

            $table->integer('times_viewed')->default(0);
            $table->datetime('valid_until');

            $table->datetime('service_date');

            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->foreign('sub_category_id')
                ->references('id')
                ->on('subcategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
