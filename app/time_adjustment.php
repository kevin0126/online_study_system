<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class time_adjustment extends Model
{
    //
    protected $table = 'time_adjustment';
    protected $primaryKey = 'timeAdjID';
    protected $appends = array('info_type');

    public function getInfoTypeAttribute()
    {
        return 2;
    }
}
