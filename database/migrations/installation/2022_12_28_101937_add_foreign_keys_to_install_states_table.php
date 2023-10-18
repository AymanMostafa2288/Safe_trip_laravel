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
        Schema::table('install_states', function (Blueprint $table) {
            $table->foreign(['country_id'])->references(['id'])->on('install_countries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_states', function (Blueprint $table) {
            $table->dropForeign('install_states_country_id_foreign');
        });
    }
};
