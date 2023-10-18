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
        Schema::create('install_admins', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->enum('type', ['employee', 'manger', 'super_manger'])->nullable()->default('employee');
            $table->integer('is_developer')->nullable();
            $table->integer('is_active');
            $table->integer('role_id')->index('role_id');
            $table->integer('branch_id')->index('branch_id')->default(1);
            $table->longText('specific_permissions')->nullable();
            $table->longText('remember_token')->nullable();
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
        Schema::dropIfExists('install_admins');
    }
};
