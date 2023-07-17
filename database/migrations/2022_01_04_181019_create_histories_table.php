<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_time')->nullable();
            // $table->timestamp('recorded_time')->nullable();
            $table->string('card_id');
            $table->string('name');
            $table->string('phone_no');
            $table->string('no_of_client');
            $table->string('socks');
            $table->string('sock_cost_at_time');
            $table->string('sock_cost_total');
            $table->string('water');
            $table->string('water_cost_at_time');
            $table->string('water_cost_total');
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();
            $table->string('interval');
            $table->string('paid_amount');

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
        Schema::dropIfExists('histories');
    }
}
