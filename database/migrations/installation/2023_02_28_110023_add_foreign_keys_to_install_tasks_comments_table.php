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
        Schema::table('install_tasks_comments', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('install_admins')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['mention_to'])->references(['id'])->on('install_admins')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['task_id'])->references(['id'])->on('install_tasks')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('install_tasks_comments', function (Blueprint $table) {
            $table->dropForeign('install_tasks_comments_admin_id_foreign');
            $table->dropForeign('install_tasks_comments_mention_to_foreign');
            $table->dropForeign('install_tasks_comments_task_id_foreign');
        });
    }
};
