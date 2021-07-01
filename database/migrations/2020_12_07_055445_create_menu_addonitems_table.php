<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuAddonitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_addonitems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('addon_category_id');
            $table->unsignedBigInteger('addon_item_id');
            $table->unsignedInteger('min')->default(1);
            $table->unsignedInteger('max')->default(1);
            $table->boolean('required')->default(0);
            $table->boolean('multiple')->default(0);
            $table->timestamps();
            $table->index('menu_id');
            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade')->onUpdate('no action');
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
        Schema::table('menu_addonitems', function (Blueprint $table) {
            //$table->dropForeign('menu_id');
			//$table->dropColumn('menu_id');
            //$table->dropForeign('addon_category_id');
            //$table->dropForeign('addon_item_id');
        });
        Schema::dropIfExists('menu_addonitems');
    }
}
