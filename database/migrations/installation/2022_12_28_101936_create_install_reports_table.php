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
        Schema::create('install_reports', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('name');
            $table->string('is_active');
            $table->string('table_db');
            $table->string('show_in')->default('left_side');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->string('with_group')->nullable();
            $table->integer('with_report')->nullable();
            $table->longText('db_joins')->nullable();
            $table->longText('db_condtions')->nullable();
            $table->longText('db_select')->nullable();
            $table->mediumText('export_as')->nullable();
            $table->string('group_by')->nullable();
            $table->integer('limit')->nullable();
            $table->string('text_align')->default('left');
            $table->mediumText('report_order_by')->nullable();
            $table->longText('report_addtinal_filter')->nullable();
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
        Schema::dropIfExists('install_reports');
    }
};
