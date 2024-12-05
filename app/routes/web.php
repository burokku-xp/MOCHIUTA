<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\Testcontroller;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DisplayController::class, 'title'])->name('title');
Route::get('/test', [Testcontroller::class, 'test'])->name('test');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/mypage', [DisplayController::class, 'mypage'])->name('mypage');
    Route::post('/mypage', [RegistrationController::class, 'listRegist'])->name('list.Regist');

    Route::group(['middleware' => 'can:view,song_list'], function () {
        Route::get('/song_list/{song_list}/detail', [DisplayController::class, 'songDetail'])->name("song.detail");
        Route::post('/song_searchResult/{song_list}/search', [DisplayController::class, 'songSearch'])->name("song.search");
        Route::post('/artist_searchResult/{song_list}/search', [DisplayController::class, 'artistSearch'])->name("artist.search");
        Route::post('/song_list/{song_list}/detail', [RegistrationController::class, 'listContentRegist'])->name("song.regist");
    });

    Route::post('/song_destroy', [AjaxController::class, 'songDestroy'])->name("song.destroy");
    Route::post('/song_edit', [AjaxController::class, 'songEdit'])->name("song.edit");
    Route::post('/user_searchResult', [DisplayController::class, 'userSearchResult'])->name("user.searchResult");
    Route::get('/user_searchResult/{song_list}', [DisplayController::class, 'userSearchList'])->name("search.list");
});

Route::post('/test', [TestController::class, 'test'])->name("test");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
