<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStackingDepositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stacking_deposites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->bigInteger('txnid');
            $table->decimal('amount',36,8)->default(0);
            $table->decimal('usdt',36,8)->default(0);
            $table->integer('planid');
            $table->text('capamount')->nullable();
            $table->smallInteger('status')->default(1);
            $table->smallInteger('roidouble')->default(1)->comment('single 1 double 2');
            $table->smallInteger('istatus')->default(1);
            $table->smallInteger('levelincome')->default(1)->comment('off 0 on 1');
            $table->smallInteger('staketype')->default(1)->comment('real 1 loan 2 gold 3 silver 4');
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
        Schema::dropIfExists('stacking_deposites');
    }
}
