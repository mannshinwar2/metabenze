<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->smallInteger('clubid');
            $table->decimal('amount',36,8)->default();
            $table->decimal('remaining',36,8)->default();
            $table->decimal('amt_usdt',36,8)->default();
            $table->string('txnDesc',50)->nullable();
            $table->bigInteger('power')->default(0);
            $table->bigInteger('weaker')->default(0);
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
        Schema::dropIfExists('club_incomes');
    }
}
