<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('menu_type_id');
            $table->unsignedMediumInteger('sort_order')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('menu_type_id')->references('id')->on('menu_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //$table->dropForeign('menu_type_id');
           // $table->dropColumn('menu_type_id');
        });
        Schema::dropIfExists('categories');
    }
}
