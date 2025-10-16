<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountDeposit extends Model
{
    public $timestamps=false;

    protected $fillable =['userid','amount','created_at','updated_at'];
}
