<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_sheet_id')->unsigned();
            $table->foreign('booking_sheet_id')
                ->references('id')
                ->on('booking_sheets')
                ->onDelete('cascade');
            $table->bigInteger('resource_type_id')->unsigned();
            $table->foreign('resource_type_id')
                ->references('id')
                ->on('resource_types')
                ->onDelete('cascade');
            $table->string('title', 100);
            $table->text('business_hours')->nullable();
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
        Schema::dropIfExists('resources');
    }
}
