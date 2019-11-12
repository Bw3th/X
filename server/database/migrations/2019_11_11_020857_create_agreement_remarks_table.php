<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agreememt_id')->default('')->comment('合同ID');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('type')->default('')->comment('备注类型');
            $table->string('file')->default('')->comment('上传文件ID');
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
        Schema::dropIfExists('agreement_remarks');
    }
}
