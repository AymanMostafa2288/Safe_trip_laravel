<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_trips', function (Blueprint $table) {
            $table->foreign(['bus_id'])->references(['id'])->on('bus_buses')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['driver_id'])->references(['id'])->on('bus_workers')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['route_id'])->references(['id'])->on('bus_routes')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['supervisor_id'])->references(['id'])->on('bus_workers')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_trips', function (Blueprint $table) {
            $table->dropForeign('bus_trips_bus_id_foreign');
            $table->dropForeign('bus_trips_driver_id_foreign');
            $table->dropForeign('bus_trips_route_id_foreign');
            $table->dropForeign('bus_trips_supervisor_id_foreign');
        });
    }
};
