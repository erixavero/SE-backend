<?php

namespace App\Http\Controllers;
use SpotifyWebAPI;
use App\Spotifytoken;
use Exception;

use Illuminate\Http\Request;

class SpotifyAPI extends Controller
{

	public function __construct(SpotifyWebAPI\SpotifyWebAPI $api,Spotifytoken $data )
	{
		$this->api = $api;
		$this->data = $data;
	}
    public function auth()
    {
    	 $session = new SpotifyWebAPI\Session(
    	'be30530eafbc4dc4a2fd98b45a508de9',
    	'0bbe0303a0194441ba734352e11a2a48',
    	'http://localhost:8000'
		);

		$options = [
		    'scope' => [
		        'user-read-currently-playing',
		        'user-read-playback-state',
		        'user-modify-playback-state',
		    ],
		];

		header('Location: ' . $session->getAuthorizeUrl($options));
		die();
    }

    public function login(Request $request)
    {
    	$session = new SpotifyWebAPI\Session(
    'be30530eafbc4dc4a2fd98b45a508de9',
    '0bbe0303a0194441ba734352e11a2a48',
    'http://localhost:8000'
	);

	// Request a access token using the code from Spotify
	$session->requestAccessToken("AQCqpZqW5t8qaFsK4gTb8KfJbqmjPPAJShGGhy7wH-4V1uEu_xtUm3x8Tg-iJF_jpkitFfNBH0a0B71jugFRQHdOOlaEAMJAtsR-a4C5tREc7PucELbJIXbDr_TfORbDEmHXIWWsJho-PhFyfubMYctmgaHJriVLvQ5YeyaM0wxgJCOHr35vBF0kJRr6JswB2VYDsID7PoNqb9bf33ef7HQ-cXKd-h6Z6VG_zEDkHcG9cvwMyt9F6q_8pjkogdmDUKHIOMZEBPgHI3vY--0Icn9RWQq-chKYjimTl9ugX5s");

	$accessToken = $session->getAccessToken();
	$refreshToken = $session->getRefreshToken();

	$data = [
            "accessToken" => $accessToken,
            "refreshToken" => $refreshToken
        ];
        try {
            $data = $this->data->create($data);
            return response()->json($data,201);
        }
        catch(Exception $ex) {
            echo $ex;
            return response('Failed', 400);
        }

	// Store the access and refresh tokens somewhere. In a database for example.
	
    }


    public function getTrackInformation()
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$data = $this->api->getMyCurrentTrack();
  	return response()->json($data);
  }

  public function playTrack()
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->play(false, [
    'uris' => [],
	]);
  }

  public function pauseTrack()
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
    $this->api->pause();		
  }

  public function nextTrack()
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->next();
  }

  public function previousTrack()
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->previous();
  }

  public function trackShuffle(Request $request)
  {
  	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->shuffle([
    'state' => $request->shuffle,
	]);
  }

 public function trackRepeat(Request $request)
 {
 	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->repeat([
    'state' => $request->repeat,
	]);
 }

 public function trackVolume(Request $request)
 {
 	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->changeVolume([
    'volume_percent' => $request->volume,
	]);
 }

 public function trackSeek(Request $request)
 {
 	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->seek([
    'position_ms' => $request->seek,
	]);
 }
}
