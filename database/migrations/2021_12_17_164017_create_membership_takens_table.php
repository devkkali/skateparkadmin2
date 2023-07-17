<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipTakensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_takens', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('membership_user_id')->unsigned();
            $table->foreign('membership_user_id')->references('id')->on('membership_users')->onDelete('cascade');

            $table->bigInteger('membership_type_id')->unsigned()->nullable();
            $table->foreign('membership_type_id')->references('id')->on('membership_types')->onDelete('set null');




            $table->timestamp('starting_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->string('cost');
            $table->string('paid');

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
        Schema::dropIfExists('membership_takens');
    }
}
