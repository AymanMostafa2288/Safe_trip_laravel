<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Custom\TransactionStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wallet_id')->index('bus_transactions_wallet_id_foreign');
            $table->unsignedBigInteger('member_id')->index('bus_transactions_member_id_foreign');
            $table->string('operation', 250);
            $table->string('transaction_num', 250);
            $table->decimal('amount', 11,2);
            $table->string('status', 50)->default(TransactionStatusEnum::PENDING);
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
        Schema::dropIfExists('bus_transactions');
    }
};
