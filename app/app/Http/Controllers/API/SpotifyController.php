<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AccessTokenController;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function test()
    {
        $token = new AccessTokenController;
        $token = $token->getSpotifyAccessToken();/*アクセストークンを取得(汎用)*/

        /*ここからテスト用コード*/
        $releases = $token->getNewReleases([
            'country' => 'ja',
        ]);
        $playlists = $token->getFeaturedPlaylists([
            'country' => 'se',
            'locale' => 'sv_SE',
            'timestamp' => '2015-01-17T21:00:00', // Saturday night
        ]);
        $result = $token->search('サカナクション', 'artist');
        return $result;
    }

    public function song_serch() {}
    //
}
