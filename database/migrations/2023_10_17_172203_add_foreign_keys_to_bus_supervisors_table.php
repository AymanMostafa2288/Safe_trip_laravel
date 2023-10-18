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
        Schema::table('bus_supervisors', function (Blueprint $table) {
            $table->foreign(['worker_id'])->references(['id'])->on('bus_wallets')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_supervisors', function (Blueprint $table) {
            $table->dropForeign('bus_supervisors_worker_id_foreign');
        });
    }
};
