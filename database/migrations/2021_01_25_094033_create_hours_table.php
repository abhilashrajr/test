<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->boolean('active')->default('1');
            $table->time('start1')->nullable();
            $table->time('end1')->nullable();
            $table->time('start2')->nullable();
            $table->time('end2')->nullable();
            $table->boolean('offer')->default('0');
            $table->decimal('offer_coll', 10, 2)->nullable()->default('0');
            $table->decimal('offer_deli', 10, 2)->nullable()->default('0');
            $table->decimal('coll_min', 10, 2)->nullable()->default('0');
            $table->decimal('deli_min', 10, 2)->nullable()->default('0');
            $table->decimal('offer_payn', 10, 2)->nullable()->default('0');
            $table->decimal('payn_min', 10, 2)->nullable()->default('0');
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
        Schema::dropIfExists('hours');
    }
}
