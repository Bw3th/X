<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_companies', function (Blueprint $table) {
            $table->increments('id');
            $tabke->string('company_name')->default('')->comment('单位名称');
            $tabke->string('contacts')->default('')->comment('联系人');
            $tabke->string('identification_number')->default('')->comment('纳税人识别号');
            $tabke->string('address')->default('')->comment('地址');
            $tabke->string('mobile')->default('')->comment('电话号码');
            $tabke->string('opening_bank')->default('')->comment('开户行名称');
            $tabke->string('bank_num')->default('')->comment('开户行账户');
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
        Schema::dropIfExists('agreement_companies');
    }
}
