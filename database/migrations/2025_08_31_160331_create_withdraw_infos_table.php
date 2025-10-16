<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('txnid');
            $table->smallInteger('txntype')->default(0)->comments('0=withdraw');
            $table->decimal('stacking',36,6)->default(0);
            $table->decimal('level',36,6)->default(0);
            $table->decimal('club',36,6)->default(0);
            $table->decimal('salary',36,6)->default(0);
            $table->decimal('bonus',36,6)->default(0);
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
        Schema::dropIfExists('withdraw_infos');
    }
}
