<?php
// namespace Corals\Modules\CourtBooking\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courtbooking_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('resourceId', 100)->nullable();
            $table->string('resourceIds', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->boolean('open')->default(1);
            $table->smallInteger('max_participants')->default(4);
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courtbooking_bookings');
    }
}
