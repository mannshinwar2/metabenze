<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanTransactions extends Model
{
    public $timestamps=false;

    protected $fillable =['loanid','amount','txntype','updated_at'];
}
