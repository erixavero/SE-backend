<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;
use Exception;
use Carbon;

class CalendarController extends Controller
{
    protected $data;

    public function __construct(Calendar $data)
    {
        $this->data = $data;
        
    }

    public function create(Request $request){
        $data = [
            "user_id" => $request -> user_id,
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
            $data = $this->data->where('date','=',$date)->
                join('users', 'users.id', '=', 'calendars.user_id')
                 ->select('calendars.id', 'calendars.event', 'users.id AS user_id','users.name AS name', 'calendars.date','calendars.time')
                 ->first();
            return response()->json($data,200);
        }
        catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

    public function showTodayDate()
    {
        $mytime = Carbon\Carbon::now();
        $time = $mytime->format('d-m-Y');
        try {
            $data = $this->data->where('date','=',$time)->
                join('users', 'users.id', '=', 'calendars.user_id')
                 ->select('calendars.id', 'calendars.event', 'users.id AS user_id','users.name AS name', 'calendars.date','calendars.time')->get();
            return response()->json($data,200);
        }
        catch (Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }
    }

}
