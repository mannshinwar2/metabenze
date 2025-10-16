<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawInfo extends Model
{
    public $timestamps=false;

    protected $fillable=['txnid','txntype','stacking','level','club','salary','bonus','updated_at'];
}
