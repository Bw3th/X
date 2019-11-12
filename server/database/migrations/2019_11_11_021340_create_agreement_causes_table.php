<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementCausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_causes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cause_name')->default('')->comment('活动名称');
            $table->integer('type')->default('')->comment('备注类型');
            $table->string('file')->default('')->comment('附件');
            $table->string('file')->default('')->comment('附件');
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
        Schema::dropIfExists('agreement_causes');
    }
}
