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
        Schema::table('install_notifiable', function (Blueprint $table) {
            $table->foreign(['notification_id'])->references(['id'])->on('install_notifications')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_notifiable', function (Blueprint $table) {
            $table->dropForeign('install_notifiable_notification_id_foreign');
        });
    }
};
