<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    public $timestamps=false;

    protected $fillable=['userid','txntype','amountsftc','amountusdt','remaining','paymentstatus','txndesc','comments','planid','plan_status','currency','paidby','release_date','deduction','net_amount','b_status','created_at','updated_at'];

    public function transactionInfo(){
        return $this->hasMany('\App\TransactionInfo','txnid','id');
    }

    public function walletTransfer(){
        return $this->hasOne('\App\WalletTransfer','txnid','id');
    }

    public function userDetail(){
        return $this->hasOne('\App\UserDetails','userid','id');
    }
}
