<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid');
            $table->bigInteger('sponsorid');
            $table->smallInteger('level')->default(0);
            $table->smallInteger('uplevel')->default(0);
            $table->integer('total_direct')->default(0);
            $table->integer('active_direct')->default(0);
            $table->integer('total_downline')->default(0);
            $table->integer('active_downline')->default(0);
            $table->decimal('level_income',36,8)->default(0);
            $table->decimal('roi_income',36,8)->default(0);
            $table->decimal('wallet_amount',36,8)->default(0);
            $table->decimal('total_investment',36,8)->default(0);
            $table->decimal('current_investment',36,8)->default(0);
            $table->decimal('total_level_investment',36,8)->default(0);
            $table->decimal('current_level_investment',36,8)->default(0);
            $table->decimal('total_self_investment',36,8)->default(0);
            $table->decimal('current_self_investment',36,8)->default(0);
            $table->decimal('total_direct_investment',36,8)->default(0);
            $table->decimal('current_direct_investment',36,8)->default(0);
            $table->smallInteger('booster')->default(1)->comment('1normal 2booster');
            $table->smallInteger('userstatus')->default(0)->comment('0inactive 1active');
            $table->smallInteger('userstate')->default(0)->comment('no of package');
            $table->smallInteger('level_status')->default(1)->comment('0not open 1 open 2 open withoutdeposite');
            $table->smallInteger('capping')->default(0)->comment('0 not cap 1 cap 2cap removed');
            $table->smallInteger('roi_status')->default(1)->comment('0 not active 1 active 2 open without');
            $table->decimal('clubuser',4,2)->default(0)->comment('club percentage');
            $table->decimal('leveluser',4,2)->default(0)->comment('level percentage');
            $table->smallInteger('power_protected')->default(0)->comment('0 not open 1 power leg open');
            $table->integer('loan_attempts')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
