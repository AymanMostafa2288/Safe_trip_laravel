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
        Schema::table('bus_transactions', function (Blueprint $table) {
            $table->foreign(['member_id'])->references(['id'])->on('bus_members')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['wallet_id'])->references(['id'])->on('bus_wallets')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_transactions', function (Blueprint $table) {
            $table->dropForeign('bus_transactions_member_id_foreign');
            $table->dropForeign('bus_transactions_wallet_id_foreign');
        });
    }
};
