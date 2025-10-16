<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->bigInteger('fromuser')->default(0);
            $table->decimal('amount',36,2)->default(0);
            $table->decimal('remaining',36,2)->default(0);
            $table->decimal('amt_usdt',36,8)->default(0);
            $table->bigInteger('txnid')->default(0);
            $table->string('description',2)->comment('d=direct l=level');
            $table->smallInteger('status')->default(0);
            $table->bigInteger('intxna')->default(0);
            $table->bigInteger('intxnb')->default(0);
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
        Schema::dropIfExists('level_incomes');
    }
}
