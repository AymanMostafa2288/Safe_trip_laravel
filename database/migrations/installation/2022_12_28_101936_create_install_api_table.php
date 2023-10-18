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
        Schema::create('install_api', function (Blueprint $table) {
            $table->comment('');
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('route_name');
            $table->string('type')->default('get');
            $table->longText('form_body')->nullable();
            $table->longText('note')->nullable();
            $table->longText('prams_counters')->nullable();
            $table->longText('form_header')->nullable();
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
        Schema::dropIfExists('install_api');
    }
};
