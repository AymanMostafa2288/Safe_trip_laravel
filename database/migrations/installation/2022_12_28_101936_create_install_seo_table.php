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
        Schema::create('install_seo', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('url', 300)->index();
            $table->string('meta_title')->nullable();
            $table->mediumText('meta_desc')->nullable();
            $table->mediumText('meta_canonical')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->mediumText('web_h1')->nullable();
            $table->mediumText('web_h2')->nullable();
            $table->longText('web_faqs')->nullable();
            $table->longText('web_blog')->nullable();
            $table->longText('web_short_links')->nullable();
            $table->longText('breadcrumbs')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('install_seo');
    }
};
