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
        Schema::create('install_states', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('name_en');
            $table->string('name_ar');
            $table->unsignedBigInteger('country_id')->nullable()->index('install_states_country_id_foreign');
            $table->string('code');
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
        Schema::dropIfExists('install_states');
    }
};
