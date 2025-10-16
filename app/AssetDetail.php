<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetDetail extends Model
{
    public $timestamps=false;

    protected $fillable =['userid','bep20addr','usdttrc20addr','usdtbep20addr','asset_status','updated_at'];
}
