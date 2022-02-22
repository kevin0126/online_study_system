<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
    //
    protected $table = 'exam';
    protected $primaryKey = 'examID';
    protected $appends = array('info_type');

    public function getInfoTypeAttribute()
    {
        return 0;
    }
}
