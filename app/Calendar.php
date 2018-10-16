<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendars';
    protected $fillable = ['id','event','date','time'];
    protected $guarded = [];
    public $timestamps = false;
}
