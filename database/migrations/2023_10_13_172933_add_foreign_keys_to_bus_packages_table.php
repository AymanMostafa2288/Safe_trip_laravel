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
        Schema::table('bus_packages', function (Blueprint $table) {
            $table->foreign(['route_id'])->references(['id'])->on('bus_routes')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_packages', function (Blueprint $table) {
            $table->dropForeign('bus_packages_route_id_foreign');
        });
    }
};
