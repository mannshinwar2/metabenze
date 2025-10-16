<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StackingDeposite extends Model
{
    public $timestamps=false;

    protected $fillable=['userid','txnid','amount','usdt','planid','status','istatus','created_at','updated_at','capamount','roidouble','levelincome','staketype'];

    public function userDetail(){
        return $this->belongsTo('\App\UserDetails','userid','id')->first();
    }

    public function walletTransfer(){
        return $this->belongsTo('\App\WalletTransfer','txnid','id')->first();
    }

    public function planDetail(){
        return $this->belongsTo('\App\StackingDetail','planid','id')->first();
    }
}
