<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('收款人名称');
            $table->integer('sex')->comment('性别');
            $table->integer('company')->comment('收款人单位');
            $table->string('mobile')->comment('电话号码');
            $table->string('IDcard')->comment('身份证号码');
            $table->string('bank_id')->comment('银行卡ID');
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
        Schema::dropIfExists('members');
    }
}
