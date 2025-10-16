<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetDetailChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_detail_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->string('bep20addr',100)->nullable();
            $table->string('usdttrc20addr',100)->nullable();
            $table->string('usdtbep20addr',100)->nullable();
            $table->string('email')->nullable();
            $table->string('contact',15)->nullable();
            $table->timestamp('email_time')->nullable();
            $table->smallInteger('asset_status')->default(1)->comment('2mail sent ,1mail failed 0task completed');
            $table->text('token')->nullable();
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
        Schema::dropIfExists('asset_detail_changes');
    }
}
