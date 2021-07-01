<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->dateTime('order_time');
            $table->unsignedBigInteger('voucher_id');
            $table->decimal('voucher_amount', 10, 2);
            $table->string('purchase_code');
            $table->unsignedInteger('payment_method');
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
        Schema::dropIfExists('voucher_orders');
    }
}
