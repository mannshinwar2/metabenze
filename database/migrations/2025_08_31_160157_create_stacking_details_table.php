<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStackingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stacking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('min_amount',36,8)->default(0);
            $table->decimal('max_amount',36,8)->default(0);
            $table->decimal('cps',5,2)->default(0);
            $table->integer('duration')->default(0)->comment('in months');
            $table->smallInteger('status')->default(1);
            $table->smallInteger('roidouble')->default(1)->comment('single 1 double 2');
            $table->decimal('capping',5,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stacking_details');
    }
}
