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
        Schema::create('install_modules', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('name', 500);
            $table->string('icone',20)->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('show_in_left_side')->default(1);
            $table->longText('fields_action')->nullable();
            $table->string('table_db');
            $table->integer('crud_with')->nullable()->index('crud_with');
            $table->string('with_group', 300)->nullable();
            $table->string('name_repo')->nullable();
            $table->string('folder_repo')->nullable();
            $table->string('model_repo')->nullable();
            $table->string('route_repo')->nullable();
            $table->string('controller_repo')->nullable();
            $table->longText('departments_module')->nullable();
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
        Schema::dropIfExists('install_modules');
    }
};
