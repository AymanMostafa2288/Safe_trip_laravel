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
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('school_id')->index('bus_routes_school_id_foreign');
            $table->mediumText('name_ar');
            $table->mediumText('name_en');
            $table->mediumText('address_from');
            $table->mediumText('address_to');
            $table->mediumText('location_from');
            $table->mediumText('location_to');
            $table->date('date_from');
            $table->date('date_to');
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
        Schema::dropIfExists('bus_routes');
    }
};
