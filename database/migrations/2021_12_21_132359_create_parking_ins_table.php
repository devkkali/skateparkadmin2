<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_ins', function (Blueprint $table) {
            $table->id();
            $table->string('card_id');
            $table->string('name');
            $table->string('phone_no');
            $table->string('deposite');
            $table->timestamp('in_time')->nullable();
            // $table->string('out_time');
            // $table->string('interval');
            $table->string('paid_amount');
            $table->string('sock_cost_at_time');
            $table->string('water_cost_at_time');
            $table->string('socks');
            $table->string('water');
            $table->string('no_of_client');
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
        Schema::dropIfExists('parking_ins');
    }
}
