<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;
use Exception;

class CalendarController extends Controller
{
    protected $data;

    public function __construct(Calendar $data)
    {
        $this->data = $data;
    }

    public function create(Request $request){
        $data = [
            "event" => $request -> event,
            "date" => $request -> date,
            "time" => $request -> time
        ];
        try {
            $data = $this->data->create($data);
            return response()->json($data,201);
        }
        catch(Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function showAll(){
        try {
            return calendar::all();
        }
        catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function showByDate($date){
        try {
            $data = $this->data->where('date','=',$date)->get();
            return response()->json($data,200);
        }
        catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

}
