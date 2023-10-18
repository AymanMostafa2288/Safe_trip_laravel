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
        Schema::create('install_permission_moduel_roles', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('role_id')->index('role_id');
            $table->integer('module_id')->index('module_id');
            $table->integer('permission_id')->index('permission_id');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('install_permission_moduel_roles');
    }
};
