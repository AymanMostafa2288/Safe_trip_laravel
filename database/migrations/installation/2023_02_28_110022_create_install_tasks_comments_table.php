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
        Schema::create('install_tasks_comments', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id')->index('install_tasks_comments_admin_id_foreign');
            $table->unsignedBigInteger('task_id')->index('install_tasks_comments_task_id_foreign');
            $table->mediumText('comment')->nullable();
            $table->unsignedBigInteger('mention_to')->nullable()->index('install_tasks_comments_mention_to_foreign');
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
        Schema::dropIfExists('install_tasks_comments');
    }
};
