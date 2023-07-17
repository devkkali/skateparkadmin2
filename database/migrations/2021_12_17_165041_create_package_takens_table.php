<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTakensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_takens', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('package_user_id')->unsigned();
            $table->foreign('package_user_id')->references('id')->on('package_users')->onDelete('cascade');;

            $table->bigInteger('package_type_id')->unsigned()->nullable();
            $table->foreign('package_type_id')->references('id')->on('package_types')->onDelete('set null');;


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
        Schema::dropIfExists('package_takens');
    }
}
