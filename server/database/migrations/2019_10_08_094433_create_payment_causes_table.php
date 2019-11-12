<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_causes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cause_name')->comment('事由名称');
            $table->integer('cause_type')->comment('事由类型');
            $table->integer('final_status')->comment('最终状态');
            $table->integer('process_status')->comment('过程状态');
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
        Schema::dropIfExists('payment_causes');
    }
}
