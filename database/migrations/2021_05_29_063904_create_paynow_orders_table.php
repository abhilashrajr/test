<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynowOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynow_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('tableno')->nullable();
            $table->dateTime('order_time');
            $table->decimal('drinks_amount', 10, 2);
            $table->decimal('food_amount', 10, 2);
            $table->decimal('drinks_discount', 10, 2);
            $table->decimal('food_discount', 10, 2);
            $table->decimal('drinks_total', 10, 2);
            $table->decimal('food_total', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('payment_method');
            $table->unsignedInteger('payment_status')->default(0);
            $table->unsignedInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynow_orders');
    }
}
