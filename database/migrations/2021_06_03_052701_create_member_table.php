<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('contactno')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->text('device_id')->nullable();
            $table->dateTime('d_id_modified_at')->nullable();          
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
        Schema::dropIfExists('member');
    }
}
