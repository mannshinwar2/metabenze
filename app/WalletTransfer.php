<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{
    public $timestamps=false;

    protected $fillable=['txnid','userid','fromWallet','toWallet','amount','fromUser','release_date','created_at','updated_at'];

    public function stackingDeposite(){
        return $this->hasOne('\App\StackingDeposite','txnid','id')->first();
    }

    public function loanDetails(){
        return ($this->fromWallet==="loan")? $this->belongsTo('\App\LoanDetails','txnid','id')->first() :null;
    }
    
}
