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
        Schema::create('install_charts', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('name');
            $table->string('type');
            $table->string('active');
            $table->integer('width');
            $table->integer('height');
            $table->mediumText('labels');
            $table->longText('datasate_config');
            $table->longText('sql_statments')->nullable();
            $table->string('module_related')->nullable();
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
        Schema::dropIfExists('install_charts');
    }
};
