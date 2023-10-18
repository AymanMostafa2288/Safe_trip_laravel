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
        Schema::table('install_permission_moduel_roles', function (Blueprint $table) {
            $table->foreign(['role_id'], 'install_permission_moduel_roles_ibfk_1')->references(['id'])->on('install_roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['module_id'], 'install_permission_moduel_roles_ibfk_2')->references(['id'])->on('install_modules')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['permission_id'], 'install_permission_moduel_roles_ibfk_3')->references(['id'])->on('install_permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_permission_moduel_roles', function (Blueprint $table) {
            $table->dropForeign('install_permission_moduel_roles_ibfk_1');
            $table->dropForeign('install_permission_moduel_roles_ibfk_2');
            $table->dropForeign('install_permission_moduel_roles_ibfk_3');
        });
    }
};
