<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Custom\TripStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id')->index('bus_trips_route_id_foreign');
            $table->unsignedBigInteger('driver_id')->index('bus_trips_driver_id_foreign');
            $table->unsignedBigInteger('supervisor_id')->index('bus_trips_supervisor_id_foreign');
            $table->unsignedBigInteger('bus_id')->index('bus_trips_bus_id_foreign');
            $table->mediumText('trip_id');
            $table->date('day');
            $table->time('time_start');
            $table->time('time_end');
            $table->dateTime('actual_time_start')->nullable();
            $table->dateTime('actual_time_end')->nullable();
            $table->string('status', 50)->default(TripStatusEnum::NOT_YET);
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('bus_trips');
    }
};
