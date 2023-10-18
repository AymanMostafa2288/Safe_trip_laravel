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
        Schema::create('install_countries', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('code', 5);
            $table->string('iso', 5)->nullable();
            $table->string('iso3', 5)->nullable();
            $table->string('numcode', 5)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('install_countries');
    }
};
