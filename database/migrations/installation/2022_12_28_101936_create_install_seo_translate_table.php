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
        Schema::create('install_seo_translate', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('meta_title')->nullable();
            $table->mediumText('meta_desc')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->unsignedBigInteger('seo_id')->index();
            $table->string('lang', 4)->index();
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
        Schema::dropIfExists('install_seo_translate');
    }
};
