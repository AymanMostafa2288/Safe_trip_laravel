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
        Schema::create('bus_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('family_id')->index('bus_members_family_id_foreign');
            $table->string('name', 250);
            $table->string('email', 250)->unique();
            $table->string('phone', 250)->unique();
            $table->string('national_id', 250)->unique();
            $table->string('password', 250);
            $table->string('gander', 20);
            $table->string('relation', 25);
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
        Schema::dropIfExists('bus_members');
    }
};
