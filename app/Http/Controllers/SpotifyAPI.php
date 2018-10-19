<?php

namespace App\Http\Controllers;
use SpotifyWebAPI;

use Illuminate\Http\Request;

class SpotifyAPI extends Controller
{
	public function __construct(){
    	$api = new SpotifyWebAPI\SpotifyWebAPI();
  }


  	public function getTrackInformation()
  {
  	$api = new SpotifyWebAPI\SpotifyWebAPI();

  	 $data = $api->getMyCurrentTrack();
  	 return response()->json($data);
  }

  public function playTrack(Request $request, Request $deviceId)
  {
  	 $api->play($deviceId, [
    'uris' => [$request],
    ]);
  }

  public function pauseTrack()
  {
  	try {
    $wasPaused = $api->pause();	

    if (!$wasPaused) {
        $lastResponse = $api->getLastResponse();

        if ($lastResponse['status'] == 202) {
            $api->pause();
        }
   	 }
	} 
	catch (Exception $e) {

    return response()->json(['error' => "it screwed up"], 404);
	
	}
  	
  }

  public function nextTrack()
  {
  	$api->next();
  }

  public function previousTrack()
  {
  	$api->previous();
  }

  public function trackShuffleon(Request $request)
  {
  	$api->shuffle([
    'state' => $request->shuffle,
	]);
  }

 public function trackRepeat(Request $request)
 {
 	$api->repeat([
    'state' => $request->repeat,
	]);
 }

 public function trackVolume(Request $request)
 {
 	$api->changeVolume([
    'volume_percent' => $request->volume,
	]);
 }

 public function trackSeek(Request $request)
 {
 	$api->seek([
    'position_ms' => $request->seek,
	]);
 }

}

