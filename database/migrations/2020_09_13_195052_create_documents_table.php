<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_type');
            $table->string('document_owner');
            $table->string('car');
            $table->timestamp('issue_date');
            $table->timestamp('expiry_date');
            $table->timestamp('reminder_date');
            $table->string('status')->default(0); //0 - active, 1- almost due, 2- expired
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
        Schema::dropIfExists('documents');
    }
}
