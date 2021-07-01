<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('contact_no2')->nullable();
            $table->string('email')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->boolean('delivery')->default('1');
            $table->boolean('collection')->default('1');       
            $table->boolean('active')->default('1');
            $table->boolean('test_mode')->default('0');
            $table->boolean('pre_order')->default('0');
            $table->boolean('booking')->default('0');
            $table->boolean('dinein')->default('0');
            $table->boolean('paynow')->default('0');
            $table->boolean('voucher')->default('0');
            $table->boolean('coupon')->default('0');
            $table->boolean('reject_order')->default('0');
            $table->unsignedInteger('delivery_radius')->default('0');
            $table->decimal('collection_min', 10, 2)->default('0');
            $table->decimal('delivery_min', 10, 2)->default('0');
            $table->decimal('drinks_discount', 10, 2)->default('0');
            $table->decimal('food_discount', 10, 2)->default('0');
            $table->time('preorder_start')->nullable();
            $table->string('stripe_id')->nullable();
            $table->unsignedInteger('erp_id')->nullable();
            $table->string('theme');
            $table->string('currency');
             
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
        Schema::dropIfExists('settings');
    }
}
