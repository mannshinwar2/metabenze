<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid',11)->nullable();
            $table->string('usersname',50)->nullable();
            $table->string('email',100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->string('s_password',255);
            $table->string('ccode',5)->default('91');
            $table->string('contact',15)->default('');
            $table->smallInteger('gender')->default(0)->comment('0 male 1 female 3 other');
            $table->smallInteger('licence')->default(1)->comment('1user2subadmin3admin');
            $table->smallInteger('permission')->default(1)->comment('1unlock 0 lock');
            $table->date('doj')->useCurrent();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
