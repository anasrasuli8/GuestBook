<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MessagesController;
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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout']);
Route::group([ 'middleware' => 'auth:sanctum'], function () {
    Route::get('user',function (){
        return Auth::user();
    });
    Route::post('/post', [MessagesController::class, 'saveMessage']);
    Route::post('/reply', [MessagesController::class, 'saveReply']);
    Route::get('/messages', [MessagesController::class, 'getMessages']);
//    Route::post('add', [BookController::class, 'add']);
//    Route::get('edit/{id}', [BookController::class, 'edit']);
//    Route::post('update/{id}', [BookController::class, 'update']);
//    Route::delete('delete/{id}', [BookController::class, 'delete']);
});
