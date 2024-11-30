<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AccessTokenController;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class SpotifyController extends Controller
{
    protected $token;

    public function __construct()
    {
        $token = new AccessTokenController;
        $token = $token->getSpotifyAccessToken();/*アクセストークンを取得(汎用)*/
        $this->token = $token;
    }


    /*曲名検索*/
    public function song_serch($song_name)
    {
        $options = (
            [
                'limit' => 30,     // 検索結果の数
                'offset' => 0,     // 検索結果の開始位置
                'market' => 'JP',  // 市場（オプション、US など）
                'locale' => 'ja-JP' //言語設定
            ]
        );
        $result = $this->token->search($song_name, 'track', $options);
        // アーティスト情報を整形
        return collect($result->tracks->items)->map(function ($artist) {
            return [
                'artist' => $artist->artists["0"]->name,
                'name' => $artist->name,
                'track_id' => $artist->id
            ];
        });
    }
    //
}
