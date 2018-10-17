<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendars';
    protected $fillable = ['user_id','event','date','time'];
    protected $guarded = [];
    public $timestamps = false;
}
