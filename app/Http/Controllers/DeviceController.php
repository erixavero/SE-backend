<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\LightSwitch;

use App\light;
//use App\AC;
//use App\TV;

class DeviceController extends Controller
{

  public function __construct(light $light){
    $this->light = $light;

  }

  public function stat()
  {
    try {
      $data['light'] = $this->light->orderBy('created_at', 'desc')->first();

    } catch (QueryException $e) {
      return response()->json(['error' => "it screwed up"], 404);
    }

    if(count($data)>0){
      return response()->json($data);
    }
    $default['light'] = ['status' => 'Off'];
    return response()->json($data);
  }

  public function lightOn(Request $request){
    $light=[
      "status" => $request->status
    ];

    try {
      $data = $this->light->create($light);

      broadcast(new LightSwitch($data))->toOthers();

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

      broadcast(new LightSwitch($data))->toOthers();

      return response()->json($data);
    } catch (QueryException $e) {
      return response()->json(['error' => "it screwed up"], 404);
    }
  }
}
