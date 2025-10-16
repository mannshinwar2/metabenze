<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelIncome extends Model
{
    public $timestamps=false;

    protected $fillable=['userid','amount','remaining','amt_usdt','status','intxna','intxnb','created_at','updated_at','description','txnid','fromuser',];
}
