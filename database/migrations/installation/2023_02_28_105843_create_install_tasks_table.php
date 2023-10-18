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
        Schema::create('install_tasks', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->mediumText('title');
            $table->string('status');
            $table->mediumText('images');
            $table->mediumText('description');
            $table->date('solved_at')->nullable();
            $table->string('priority');
            $table->string('type');
            $table->unsignedBigInteger('board_id')->index('install_tasks_board_id_foreign');
            $table->unsignedBigInteger('admin_id')->index('install_tasks_admin_id_foreign');
            $table->unsignedBigInteger('admin_to')->nullable()->index('install_tasks_admin_to_foreign');
            $table->date('finished_at');
            $table->integer('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('install_tasks');
    }
};
