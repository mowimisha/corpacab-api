<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('vehicle_image');
            $table->string('registration_no', 7);
            $table->string('make');
            $table->string('model');
            $table->string('yom');
            $table->string('color');
            $table->string('fuel_type');
            $table->string('status')->default(0);
            $table->string('logbook')->nullable();
            $table->string('insurance_sticker')->nullable();
            $table->string('uber_inspection')->nullable();
            $table->string('psv')->nullable();
            $table->string('ntsa_inspection')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
