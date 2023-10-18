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
        Schema::create('install_districts', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('name_en');
            $table->string('name_ar');
            $table->unsignedBigInteger('city_id')->nullable()->index('install_districts_city_id_foreign');
            $table->unsignedBigInteger('state_id')->nullable()->index('state_id');
            $table->unsignedBigInteger('country_id')->nullable()->index('install_districts_ibfk_1');
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
        Schema::dropIfExists('install_districts');
    }
};
