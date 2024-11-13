<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [DisplayController::class, 'title']);
Auth::routes();
Route::group(['middleware' => ['auth']],function () {
    Route::get('/mypage', [DisplayController::class, 'mypage'])->name('mypage');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

