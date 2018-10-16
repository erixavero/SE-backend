<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class light extends Model
{
  protected $table="light";
  protected $fillable=["status"];
}
