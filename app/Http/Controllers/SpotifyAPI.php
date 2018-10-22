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
    	'e3dc74d13f8444d6860105a175221a68',
    	'5f52a08fce90433ab251ef810501afe7',
    	'http://178.128.62.29'
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
    'e3dc74d13f8444d6860105a175221a68',
    '5f52a08fce90433ab251ef810501afe7',
    'http://178.128.62.29'
	);

	// Request a access token using the code from Spotify
	$session->requestAccessToken($request->code);

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
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$data = $this->api->getMyCurrentTrack();
  	return response()->json($data);
  }

  public function playTrack()
  {
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->play(false, false);
  }

  public function pauseTrack()
  {
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
    $this->api->pause();		
  }

  public function nextTrack()
  {
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->next();
  }

  public function previousTrack()
  {
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->previous();
  }

  public function trackShuffle(Request $request) 
  {
  	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
  	$this->api->shuffle([
    'state' => $request->shuffle,
	]);
  }

 public function trackRepeat(Request $request) //off,track,context
 {
 	$accessToken = $this->data->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->repeat([
    'state' => $request->repeat,
	]);
 }

 public function trackVolume(Request $request)
 {
 	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->changeVolume([
    'volume_percent' => $request->volume,
	]);
 }

 public function trackSeek(Request $request) // ms 
 {
 	$accessToken = $this->data->orderBy('id', 'desc')->select('spotifytokens.accessToken')->pluck('accessToken')->first();
  	$this->api->setAccessToken($accessToken);
 	$this->api->seek([
    'position_ms' => $request->seek,
	]);
 }
}
