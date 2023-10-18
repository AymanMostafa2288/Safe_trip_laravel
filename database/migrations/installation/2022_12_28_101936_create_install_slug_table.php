<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('install_slug', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true)->index('id');
            $table->mediumText('slug');
            $table->mediumText('table_name');
            $table->integer('row_id')->index('row_id');
            $table->integer('in_sitemap')->default(0);
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
        Schema::dropIfExists('install_slug');
    }
};
