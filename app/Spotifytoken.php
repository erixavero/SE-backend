<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spotifytoken extends Model
{
    protected $table = 'spotifytokens';
    protected $fillable = ['accessToken','refreshToken'];
    protected $guarded = [];
    public $timestamps = false;
}
