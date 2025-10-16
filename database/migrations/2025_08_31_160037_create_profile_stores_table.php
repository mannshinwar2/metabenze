<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('sftc')->nullable();
            $table->text('sftc_contract_addr')->nullable();
            $table->smallInteger('sftc_deposit_status')->default(1)->comment('1=on 0=off');
            $table->smallInteger('sftc_withdrawal_status')->default(1);
            $table->text('usdt')->nullable();
            $table->text('usdt_contract_addr')->nullable();
            $table->smallInteger('usdt_deposit_status')->default(1);
            $table->smallInteger('usdt_withdrawal_status')->default(1);
            $table->text('usdtbep20')->nullable();
            $table->text('usdtbep20_contract_addr')->nullable();
            $table->smallInteger('usdtbep20_deposit_status')->default(1);
            $table->smallInteger('usdtbep20_withdrawal_status')->default(1);
            $table->string('price',250)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_stores');
    }
}
