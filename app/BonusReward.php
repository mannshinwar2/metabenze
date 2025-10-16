<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusReward extends Model
{
      public $timestamps=false;

    protected $fillable =['userid','fromuser','txnid','amount','remaining','status','intxna','intxnb','created_at','updated_at','description','amt_usdt'];
}
