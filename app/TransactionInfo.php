<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionInfo extends Model
{
    public $timestamps=false;

    protected $fillable=['txnid','payment_addr','payee_addr','transaction_hash','amount','contract_addr','txn_status','created_at','updated_at'];
}
