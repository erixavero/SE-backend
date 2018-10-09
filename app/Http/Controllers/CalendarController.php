<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;

class CalendarController extends Controller
{
    protected $data;

    public function __construct(Calendar $data)
    {
        $this->data = $data;
    }

    public function store()
    {
        $data = [

        ];
    }
}
