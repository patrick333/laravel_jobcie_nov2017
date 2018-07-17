<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingconversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listingconversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->text('status')->default('NEW');
            $table->json('images');

            $table->timestamps();

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
        Schema::dropIfExists('listingconversations');
    }
}
