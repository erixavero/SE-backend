<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function lightOn(){
      try {
        $array = Array();
        $array['status'] = "on";
      } catch (QueryException $e) {
        return response()->json(['error' => "it screwed up"], 404);
      }
    }

    public function lightOff(){
      try {
        $array = Array();
        $array['status'] = "off";
      } catch (QueryException $e) {
        return response()->json(['error' => "it screwed up"], 404);
      }
    }
}
