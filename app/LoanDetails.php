<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanDetails extends Model
{
    public $timestamps=false;

    protected $fillable =['userid','amount','remaining','status','updated_at'];

    public function userDetail(){
        return $this->belongsTo('\App\UserDetails','userid','id')->first();
    }

    public function walletTransfer(){
        return $this->hasOne('\App\WalletTransfer','txnid','id')->first();
    }
}
