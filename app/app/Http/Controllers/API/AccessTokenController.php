<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebApi;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

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
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $options = [
            'form_params' => $form_params,
            'headers' => $headers
        ];

        $response = $client->post('https://accounts.spotify.com/api/token', $options);
        $access_token = json_decode($response->getBody())->access_token;
        $encrypted_access_token = Crypt::encryptString($access_token);
        session(['access_token' => $encrypted_access_token]);
        /*暗号化*/
        $session_access_token = session('access_token');
        /*復号*/
        $decrypted_access_token = Crypt::decryptString($session_access_token);
        $api = new SpotifyWebAPI();
        $api = $api->setAccessToken($decrypted_access_token);
        return $api;
    }
    //
}