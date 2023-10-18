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
        Schema::table('install_seo_translate', function (Blueprint $table) {
            $table->foreign(['seo_id'])->references(['id'])->on('install_seo')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_seo_translate', function (Blueprint $table) {
            $table->dropForeign('install_seo_translate_seo_id_foreign');
        });
    }
};
