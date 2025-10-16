<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardPopup extends Model
{
    protected $table = 'dashboard_popups';

    protected $fillable = [
        'title',
        'description',
        'image',
        'show_popup',
    ];
}

