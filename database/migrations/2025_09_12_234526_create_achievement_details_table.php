<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rewardname',20)->nullable();
            $table->bigInteger('business_min');
            $table->bigInteger('business_max');
            $table->integer('cps_amount')->default(0);
            $table->smallInteger('firstline')->default(0);
            $table->smallInteger('secondline')->default(0);
            $table->smallInteger('remainingline')->default(0);
            $table->decimal('new_business',5,2)->default(0);
            $table->smallInteger('new_business_month')->default(0);
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('achievement_details');
    }
}
