<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportQuery extends Model
{
    public $timestamps=false;

    protected $fillable=['uid','inqid','subject','title','message','answer','status','repliedby','updated_at',];
}
