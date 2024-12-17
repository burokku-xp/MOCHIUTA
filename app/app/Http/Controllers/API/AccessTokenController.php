<?php

namespace App\Http\Controllers\API;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPIException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use SpotifyWebAPI\Request as SpotifyWebAPIRequest;

require '../vendor/autoload.php';

class AccessTokenController extends Controller
{
    public function getSpotifyAccessToken()
    {
        $client = new Client();

        $form_params = [
            'grant_type' => 'client_credentials',
            'client_id' => 'f239501f21c14f5db199b7a77e793abc',
            'client_secret' => '95fa61e2aa6e4bfe8e752980913e1a04'
        ];

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept-Language' => 'ja'
        ];

        $options = [
            'form_params' => $form_params,
            'headers' => $headers
        ];

        $response = $client->post('https://accounts.spotify.com/api/token', $options);
        $access_token = json_decode($response->getBody())->access_token;
        $api = new SpotifyWebAPI();
        $api = $api->setAccessToken($access_token);
        return $api;
    }
    //
}
