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
        Schema::create('install_logs', function (Blueprint $table) {
            $table->comment('');
            $table->bigInteger('id', true);
            $table->integer('admin_id');
            $table->string('table_name', 250);
            $table->bigInteger('post_id');
            $table->string('action');
            $table->longText('old_data')->nullable();
            $table->longText('new_data')->nullable();
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
        Schema::dropIfExists('install_logs');
    }
};
