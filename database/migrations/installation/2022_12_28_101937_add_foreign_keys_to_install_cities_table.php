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
        Schema::table('install_cities', function (Blueprint $table) {
            $table->foreign(['country_id'], 'install_cities_ibfk_1')->references(['id'])->on('install_countries')->onDelete('CASCADE');
            $table->foreign(['state_id'])->references(['id'])->on('install_states')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_cities', function (Blueprint $table) {
            $table->dropForeign('install_cities_ibfk_1');
            $table->dropForeign('install_cities_state_id_foreign');
        });
    }
};
