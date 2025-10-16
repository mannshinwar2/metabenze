<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpsIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cps_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->bigInteger('txnid')->default(0);
            $table->decimal('amount',36,2)->default(0);
            $table->decimal('remaining',36,2)->default(0);
            $table->decimal('amt_usdt',36,8)->default(0);
            $table->smallInteger('status')->default(0);
            $table->bigInteger('intxna')->default(0);
            $table->bigInteger('intxnb')->default(0);
            $table->smallInteger('levelincome')->default(1)->comment('off 0 on 1');
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
        Schema::dropIfExists('cps_incomes');
    }
}
