<?php

namespace App\Http\Controllers;
use SpotifyWebAPI;

use Illuminate\Http\Request;

class SpotifyLogin extends Controller
{

	public function __construct()
	{
		$api = new SpotifyWebAPI\SpotifyWebAPI();
	}
    public function auth()
    {
    	 $session = new SpotifyWebAPI\Session(
    	'e406ab9065784cfe81eb7d970d14f895',
    	'dfc452b061164730a3663814d8300450',
    	'http://localhost:8000'
		);

		$options = [
		    'scope' => [
		        'playlist-read-private',
		        'user-read-private',
		    ],
		];

		header('Location: ' . $session->getAuthorizeUrl($options));
		die();
    }

    public function login(Request $request)
    {
    	$session = new SpotifyWebAPI\Session(
    'e406ab9065784cfe81eb7d970d14f895',
    'dfc452b061164730a3663814d8300450',
    'http://localhost:8000'
	);

	// Request a access token using the code from Spotify
	$session->requestAccessToken("AQBpuvox7Nzw804vIG3BiEkvvYSOZdxfJZ83XwRuiNfwcAsFF0Q5uRPRDUntlJTlzTc-r22BbNE3ejrr3O2rxTKPA2B2eaeFtTQ1LgeJLmR0AmCxmZp9fIomDx0vjuk7NLPpeiwRnDHv8ATB5RZMEvF6L7ssvx22FWW89PDRP2fhSDwToyTvG1G4NdeU8QZY3efk2Zi4Xgs4E1HRrw66LN7ikTeMopTCHEiwBSjpUAJRByXswabw");

	$accessToken = $session->getAccessToken();
	$refreshToken = $session->getRefreshToken();

	// Store the access and refresh tokens somewhere. In a database for example.
	$api = new SpotifyWebAPI\SpotifyWebAPI();
	$api->setAccessToken($accessToken);
	return response()->json($accessToken);
    }
}
