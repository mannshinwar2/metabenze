<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('txnid');
            $table->string('payment_addr',200)->nullable();
            $table->string('payee_addr',200)->nullable();
            $table->string('transaction_hash',200)->nullable();
            $table->decimal('amount',36,8)->default(0);
            $table->string('contract_addr',200)->nullable();
            $table->smallInteger('txn_status')->default(0)->comment('0new1txnhashsubmitted2successfull3failed4cancelled5rejected');
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
        Schema::dropIfExists('transaction_infos');
    }
}
