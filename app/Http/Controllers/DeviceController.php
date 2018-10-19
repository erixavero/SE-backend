<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\LightSwitch;

use App\light;
use App\tv;

class DeviceController extends Controller
{

  public function __construct(light $light, tv $tv){
    $this->light = $light;
    $this->tv = $tv;

  }

  public function stat()
  {
    try {
      $data['light'] = $this->light->orderBy('created_at', 'desc')->first();
      $data['tv'] = $this->tv->orderBy('created_at', 'desc')->first();

    } catch (QueryException $e) {
      return response()->json(['error' => "it screwed up"], 404);
    }

    if($data['light'] == null){
      $data['light'] = 'off';
    }
    if($data['tv'] == null){
      $data['tv']['status'] = 'off';
    }

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

  public function TVOn(Request $request){
    $tv=[
      "status" => $request->status
    ];

    try {
      $data = $this->tv->create($tv);
      return response()->json($data);
    } catch (QueryException $e) {
      return response()->json(['error' => "it screwed up"], 404);
    }
  }

  public function TVOff(Request $request){
    $tv=[
      "status" => $request->status
    ];

    try {
      $data = $this->tv->create($tv);
      return response()->json($data);
    } catch (QueryException $e) {
      return response()->json(['error' => "it screwed up"], 404);
    }
  }

}
