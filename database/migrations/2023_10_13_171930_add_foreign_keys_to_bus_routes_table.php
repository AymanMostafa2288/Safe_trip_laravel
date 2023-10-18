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
        Schema::table('bus_routes', function (Blueprint $table) {
            $table->foreign(['school_id'])->references(['id'])->on('bus_schools')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_routes', function (Blueprint $table) {
            $table->dropForeign('bus_routes_school_id_foreign');
        });
    }
};
