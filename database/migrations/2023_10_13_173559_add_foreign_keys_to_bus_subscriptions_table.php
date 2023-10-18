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
        Schema::table('bus_subscriptions', function (Blueprint $table) {
            $table->foreign(['family_id'])->references(['id'])->on('bus_families')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['package_id'])->references(['id'])->on('bus_packages')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_subscriptions', function (Blueprint $table) {
            $table->dropForeign('bus_subscriptions_family_id_foreign');
            $table->dropForeign('bus_subscriptions_package_id_foreign');
        });
    }
};
