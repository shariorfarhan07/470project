<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderslistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderlists', function (Blueprint $table) {
           $table->id();
            $table->text('order_id')->nullable();
            $table->text('item_id')->nullable();
            $table->text('item_name')->nullable();
            $table->double('item_price')->nullable();
            $table->double('qty')->nullable();
            $table->timestamps();

//            /`order_id`, `item_id`, `item_name`, `item_price`, `qty`



//array('order_id' => $order_id, 'item_id' => $item_id, 'item_name' => $item_name, 'item_price' => $item_price, 'qty' => $qty);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderlists');
    }
}
