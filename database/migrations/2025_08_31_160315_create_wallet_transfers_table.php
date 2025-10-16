<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid')->default(0);
            $table->bigInteger('txnid');
            $table->string('fromWallet',20)->comment('deposite,wallet,fixed');
            $table->string('toWallet',20)->comment('basic,wallet,fixed,withdraw');
            $table->decimal('amount',36,8)->default(0);
            $table->bigInteger('fromUser')->default(0);
            $table->date('release_date');
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
        Schema::dropIfExists('wallet_transfers');
    }
}
