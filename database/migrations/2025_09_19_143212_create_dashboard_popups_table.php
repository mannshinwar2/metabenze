<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardPopupsTable extends Migration
{
    public function up()
    {
        Schema::create('dashboard_popups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('show_popup')->default(false); // true = show, false = hide
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dashboard_popups');
    }
}
