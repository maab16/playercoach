<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courtbooking_bookings', function (Blueprint $table) {
            $table->bigInteger('user_id')->after('id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('courtbooking_booking_user', function (Blueprint $table) {
            $table->bigInteger('booking_id')->after('id')->unsigned()->nullable();
            $table->bigInteger('user_id')->after('booking_id')->unsigned()->nullable();
            $table->foreign('booking_id')->references('id')->on('courtbooking_bookings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courtbooking_bookings', function (Blueprint $table) {
            // $table->dropColumn('contact_name');
            // $table->dropColumn('contact_phone');
            // $table->dropColumn('contact_mail');
            // $table->dropColumn('deleted_at');
        });
        Schema::table('courtbooking_booking_user', function (Blueprint $table) {
            // $table->dropColumn('contact_name');
            // $table->dropColumn('contact_phone');
            // $table->dropColumn('contact_mail');
            // $table->dropColumn('deleted_at');
        });
    }
}
