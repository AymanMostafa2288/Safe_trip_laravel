<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Custom\BusStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_buses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vehicle_license', 250);
            $table->string('vehicle_number', 250);
            $table->integer('passenger_capacity')->default(1);
            $table->integer('passenger_available')->default(1);
            $table->string('color_code', 50);
            $table->string('status', 50)->default(BusStatusEnum::WORK);
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
        Schema::dropIfExists('bus_buses');
    }
};
