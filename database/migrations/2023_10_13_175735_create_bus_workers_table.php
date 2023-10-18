<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Custom\WorkerTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_workers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('code', 250)->unique();
            $table->string('mobile', 250)->unique();
            $table->string('password', 250);
            $table->string('national_id', 250)->unique();
            $table->string('logo', 250)->nullable();
            $table->string('type', 50)->default(WorkerTypeEnum::SUPERVISOR);
            $table->string('gander', 50);
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
        Schema::dropIfExists('bus_workers');
    }
};
