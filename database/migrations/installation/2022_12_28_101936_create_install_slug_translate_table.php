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
        Schema::create('install_slug_translate', function (Blueprint $table) {
            $table->comment('');
            $table->bigInteger('id', true);
            $table->integer('install_slug_id')->index('install_slug_id');
            $table->string('lang', 11)->index('lang');
            $table->mediumText('title');
            $table->mediumText('description');
            $table->mediumText('keywords');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('install_slug_translate');
    }
};
