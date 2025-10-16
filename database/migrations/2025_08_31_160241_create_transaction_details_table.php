<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->smallInteger('txntype')->default(0)->comment('0deposite1withdraw');
            $table->decimal('amountsftc',36,2)->default(0);
            $table->decimal('amountusdt',36,8)->default(0);
            $table->decimal('remaining',36,8);
            $table->smallInteger('paymentstatus')->default(0)->comment('0new 1accepted/hashsubmitted2successfull33failed4cancelled5rejected');
            $table->string('txndesc',255)->comment('userdeposite,walletdeposite,walletpayment,admintpayment');
            $table->string('comments',255)->nullable();
            $table->smallInteger('planid')->default(0);
            $table->smallInteger('plan_status')->default(0);
            $table->string('currency',10)->comment('usdterc,usdttrc,sftc');
            $table->bigInteger('paidby')->default(0);
            $table->dateTime('release_date')->useCurrent();
            $table->decimal('deduction',36,8)->default(0);
            $table->decimal('net_amount',36,8)->default(0);
            $table->smallInteger('b_status')->default(0)->comment("0waiting 1completed");
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
        Schema::dropIfExists('transaction_details');
    }
}
