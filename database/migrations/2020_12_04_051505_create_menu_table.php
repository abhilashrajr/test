<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('menu_type_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->boolean('veg')->default(0);
            $table->boolean('best_seller')->default(0);
            $table->unsignedInteger('sort_order')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('menu_type_id')->references('id')->on('menu_types')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            //$table->dropForeign('menu_type_id');
            //$table->dropForeign('category_id');
           // $table->dropForeign('size_id');
        });
        Schema::dropIfExists('menu');
    }
}
