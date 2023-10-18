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
        Schema::create('install_module_fields', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('name');
            $table->string('show_as');
            $table->integer('is_active')->default(0);
            $table->string('type');
            $table->string('related_with')->nullable();
            $table->integer('module_id')->index('module_id');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->text('regex')->nullable();
            $table->string('with_group')->nullable();
            $table->text('around_div')->nullable();
            $table->mediumText('hint')->nullable();
            $table->longText('fields_module')->nullable();
            $table->mediumText('fields_action')->nullable();
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
        Schema::dropIfExists('install_module_fields');
    }
};
