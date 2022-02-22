<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    //
    protected $table = 'assignment';
    protected $primaryKey = 'assignmentID';
    protected $appends = array('info_type');

    public function getInfoTypeAttribute()
    {
        return 1;
    }
}
