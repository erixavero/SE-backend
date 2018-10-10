<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\light;
//use App\AC;
//use App\TV;

class DeviceController extends Controller
{

  public function __construct(light $light){
    $this->light = $light;

  }

    public function lightOn(Request $request){
      $light=[
        "status" => $request->status
      ];

      try {
        $data = $this->light->create($light);
        return response()->json($data);
      } catch (QueryException $e) {
        return response()->json(['error' => "it screwed up"], 404);
      }
    }

    public function lightOff(Request $request){
      $light=[
        "status" => $request->status
      ];

      try {
        $data = $this->light->create($light);
        return response()->json($data);
      } catch (QueryException $e) {
        return response()->json(['error' => "it screwed up"], 404);
      }
    }
}
