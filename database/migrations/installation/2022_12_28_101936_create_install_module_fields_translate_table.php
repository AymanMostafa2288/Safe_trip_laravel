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
        Schema::create('install_module_fields_translate', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('module_fields_id')->index('install_module_fields_id');
            $table->string('name');
            $table->string('lang', 4);
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
        Schema::dropIfExists('install_module_fields_translate');
    }
};
