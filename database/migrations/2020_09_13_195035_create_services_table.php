<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_registration');
            $table->timestamp('service_date')->nullable();
            $table->string('current_odometer_reading')->nullable();
            $table->string('kms_serviced')->nullable();
            $table->string('next_kms_service')->nullable();
            $table->timestamp('reminder_date')->nullable();
            $table->string('status')->default(0); //0 - expired, 1- almost due, 2- active
            $table->string('battery_status')->default(0)->nullable(); //0 - not-changed, 1- changed
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
        Schema::dropIfExists('services');
    }
}
