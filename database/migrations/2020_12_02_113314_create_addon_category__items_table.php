<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_category_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('addon_category_id');
            $table->unsignedBigInteger('addon_item_id');
            $table->timestamps();
            $table->index('addon_category_id');
            $table->foreign('addon_category_id')->references('id')->on('addon_categories')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('addon_item_id')->references('id')->on('addon_items')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addon_category_items', function (Blueprint $table) {
           // $table->dropForeign('addon_category_id');
           // $table->dropForeign('addon_item_id');
        });
        Schema::dropIfExists('addon_category_items');
    }
}
