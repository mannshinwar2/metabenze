<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetDetailChanges extends Model
{
    public $timestamps=false;

    protected $fillable =['userid','bep20addr','usdttrc20addr','usdtbep20addr','email','contact','email_time','asset_status','updated_at','token'];
}

