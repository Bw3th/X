<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cause_id')->comment('事由ID');
            $table->integer('account_id')->comment('账户ID');
            $table->integer('bank_id')->comment('银行卡ID');
            $table->integer('cost')->comment('所支付金额');
            $table->integer('status')->comment('支付状态');
            $table->string('remarks')->comment('备注');
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
        Schema::dropIfExists('payment_charges');
    }
}
