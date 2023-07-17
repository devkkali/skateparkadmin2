<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingInGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_in_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parking_in_id')->unsigned();
            $table->foreign('parking_in_id')->references('id')->on('parking_ins')->onDelete('cascade');
            
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();
            $table->string('interval')->nullable();

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
        Schema::dropIfExists('parking_in_groups');
    }
}
