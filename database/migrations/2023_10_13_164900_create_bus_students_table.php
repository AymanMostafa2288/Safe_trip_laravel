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
        Schema::create('bus_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('family_id')->index('bus_students_family_id_foreign');
            $table->string('logo', 250)->nullable();
            $table->string('name', 250);
            $table->string('phone', 14)->unique();
            $table->string('code', 25)->unique();
            $table->string('gander', 20);
            $table->mediumText('address')->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('bus_students');
    }
};
