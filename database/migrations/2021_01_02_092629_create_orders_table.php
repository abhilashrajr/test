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
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
           // $table->string('customer_phone')->nullable();
            $table->string('order_type');
            $table->dateTime('order_time');
            $table->string('tableno')->nullable();
            $table->string('coupon')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('coupon_discount', 10, 2)->default('0');
            $table->decimal('delivery_charge', 10, 2);
            $table->string('delivery_phone');
            $table->string('delivery_email')->nullable();
            $table->string('delivery_postcode')->nullable();
            $table->text('delivery_address')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->text('other_info')->nullable();
            $table->unsignedBigInteger('payment_method');
            $table->boolean('pre_order')->default('0');
            $table->unsignedInteger('status')->default(1);
            $table->unsignedInteger('payment_status')->default(0);
            $table->timestamps();
            $table->index('order_type');
            $table->index(['order_type', 'status']);
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
