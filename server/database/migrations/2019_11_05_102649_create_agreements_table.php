<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entry_name')->default('')->comment('项目名称');
            $table->string('cause_id')->default('')->comment('活动ID');
            $table->string('mode')->default('')->comment('方式');
            $table->integer('cost')->default('')->comment('金额');
            $table->integer('party_A')->default(0)->comment('甲方');
            $table->integer('party_B')->default(0)->comment('乙方');
            $table->integer('agreement_status')->default(0)->comment('合同状态');
            $table->integer('payment_status')->default(0)->comment('付款状态');
            $table->integer('billing_status')->default(0)->comment('开票状态');
            $table->integer('implement_status')->default(0)->comment('执行状态');
            $table->integer('settlement_status')->default(0)->comment('结算状态');
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
        Schema::dropIfExists('agreements');
    }
}
