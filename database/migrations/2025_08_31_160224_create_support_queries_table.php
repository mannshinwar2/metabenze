<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_queries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->integer('inqid')->default(0);
            $table->string('subject',100)->default("");
            $table->string('title',255)->nullable();
            $table->text('message')->nullable();
            $table->text('answer')->nullable();
            $table->smallInteger('status')->default(0)->comment("0 = new, 1=replied ,2=closed");
            $table->smallInteger('repliedby')->default(0);
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
        Schema::dropIfExists('support_queries');
    }
}
