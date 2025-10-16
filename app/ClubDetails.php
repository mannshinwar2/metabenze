<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubDetails extends Model
{
    public $timestamps=false;

    protected $fillable =['business_min','business_max','cps_amount','powerline','remainingline','new_business','new_business_month','status','created_at','updated_at'];
}