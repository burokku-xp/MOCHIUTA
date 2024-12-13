<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AccessTokenController;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;
use Illuminate\Support\Facades\Auth;
use App\Models\List_content;
use App\Models\Song;
use App\Models\Song_list;

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
                'limit' => 15,     // 検索結果の数
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
                'track_id' => $artist->id,
                'jacket' => $artist->album->images["0"]->url
            ];
        });
    }

    public function artist_serch($artist_name)
    {
        $options = (
            [
                'limit' => 15,     // 検索結果の数
                'offset' => 0,     // 検索結果の開始位置
                'market' => 'JP',  // 市場（オプション、US など）
                'locale' => 'ja-JP' //言語設定
            ]
        );

        $result = $this->token->search($artist_name, 'artist', $options)->artists->items["0"]->id;
        $result = $this->token->getArtistTopTracks($result, $options);
        // アーティスト情報を整形
        return collect($result->tracks)->map(function ($artist) {
            return [
                'artist' => $artist->artists["0"]->name,
                'name' => $artist->name,
                'track_id' => $artist->id,
                'jacket' => $artist->album->images["0"]->url
            ];
        });
    }
    //
}
