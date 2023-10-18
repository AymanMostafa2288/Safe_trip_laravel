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
        Schema::table('bus_wallets', function (Blueprint $table) {
            $table->foreign(['family_id'])->references(['id'])->on('bus_families')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_wallets', function (Blueprint $table) {
            $table->dropForeign('bus_wallets_family_id_foreign');
        });
    }
};
