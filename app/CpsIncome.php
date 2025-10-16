<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CpsIncome extends Model
{
    public $timestamps=false;

    protected $fillable =['userid','clubid','amount','remaining','amt_usdt','txnDesc','status','intxna','intxnb','created_at','updated_at','power','weaker','txnid'];
}
