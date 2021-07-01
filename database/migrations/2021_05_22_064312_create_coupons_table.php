<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('type')->default('0');
            $table->decimal('value', 10, 2)->default('0');
            $table->unsignedInteger('reduction')->nullable();
            $table->decimal('min_amount', 10, 2)->default('0');
            $table->decimal('max_reduction', 10, 2)->default('0');
            $table->unsignedInteger('usage_limit')->default('0');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedInteger('active')->default(1);
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
        Schema::dropIfExists('coupons');
    }
}
