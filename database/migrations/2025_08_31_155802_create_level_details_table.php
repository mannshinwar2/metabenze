<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('levelname',20)->nullable();
            $table->decimal('min_amount',36,8)->default(0);
            $table->decimal('max_amount',36,8)->default(0);
            $table->integer('direct_count')->default(0);
            $table->integer('open_level')->default(0);
            $table->decimal('cps',6,3)->default(0);
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
        Schema::dropIfExists('level_details');
    }
}
