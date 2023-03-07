<?php

use Illuminate\Support\Facades\Route;
use App\Http\Actions;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', Actions\Api\Auth\LoginAction::class)->name('login');
Route::post('/logout', Actions\Api\Auth\LogoutAction::class)->name('logout');
Route::post('/register', Actions\Api\Auth\RegisterAction::class)->name('register');

Route::get('/photo', Actions\Api\Photo\IndexAction::class)->name('photo.index');
Route::get('/photo/{photo}/download', Actions\Api\Photo\DownloadAction::class);

Route::middleware('auth')->group(function () {
    Route::post('/photo', Actions\Api\Photo\CreateAction::class)->name('photo.create');
});
