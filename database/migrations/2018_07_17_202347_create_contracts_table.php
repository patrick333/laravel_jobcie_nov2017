<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->text('title');
            $table->text('description');
            $table->text('inclusion');
            $table->text('exclusion');
            $table->text('status')->default('NEW');
            $table->float('price');

            $table->json('images');
            $table->json('address');

            $table->timestamps();
            $table->datetime('service_date');

            $table->foreign('listing_id')
                ->references('id')
                ->on('listings');

            $table->foreign('provider_id')
                ->references('id')
                ->on('users');

            $table->foreign('customer_id')
                ->references('id')
                ->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
