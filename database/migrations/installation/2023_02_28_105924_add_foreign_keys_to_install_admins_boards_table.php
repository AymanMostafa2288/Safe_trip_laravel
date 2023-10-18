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
        Schema::table('install_admins_boards', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('install_admins')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['board_id'])->references(['id'])->on('install_boards')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_admins_boards', function (Blueprint $table) {
            $table->dropForeign('install_admins_boards_admin_id_foreign');
            $table->dropForeign('install_admins_boards_board_id_foreign');
        });
    }
};
