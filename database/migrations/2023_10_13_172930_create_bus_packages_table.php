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
        Schema::create('bus_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id')->index('bus_packages_route_id_foreign');
            $table->string('name_ar', 250);
            $table->string('name_en', 250);
            $table->integer('count_of_trip')->default(1);
            $table->decimal('price', 11,2);
            $table->longText('note_ar')->nullable();
            $table->longText('note_en')->nullable();
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
        Schema::dropIfExists('bus_packages');
    }
};
