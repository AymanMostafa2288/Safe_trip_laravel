<?php

use App\Enum\NotificationTypeEnum;
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
        Schema::create('install_notifications', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('table_db');
            $table->string('field_name');
            $table->string('field_value');
            $table->string('type')->default(NotificationTypeEnum::NOTIFICATION);
            $table->mediumText('message');
            $table->integer('is_active')->default(1);
            $table->bigInteger('module_id')->nullable();
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
        Schema::dropIfExists('install_notifications');
    }
};
