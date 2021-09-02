<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('flat')->nullable();
            $table->text('division')->nullable();
            $table->text('city')->nullable();
            $table->text('zip')->nullable();
            $table->text('payment')->nullable();
            $table->text('email')->nullable();
            $table->text('paymentmethod')->nullable();
            $table->text('paymentnumber')->nullable();
            $table->text('txid')->nullable();
            $table->text('submit')->nullable();
            $table->timestamps();

//            `first_name`, `last_name`, `phone`, `email`, `address`, `flat`, `city`, `division`, `zip`, `paymentmethod`, `paymentnumber`, `txid`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
