<?php

use App\Custom\Classes\CardsHandler;
use App\Custom\Classes\TurnsHandler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\LogEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('auth.login'); })->name('home');
Route::get('/lobby', [LobbyController::class, 'index'])->middleware(['auth'])->name('menu');
Route::get('/game', [GameController::class, 'index'])->middleware(['auth'])->name('game');

Route::get('/log/in', [LogEventController::class, 'login']);
Route::get('/log/out', [LogEventController::class, 'logout']);

Route::get('/lobby/connect', [LobbyController::class, 'connectToGame']);
Route::get('/lobby/ready', [LobbyController::class, 'isReady']);
Route::post('/lobby/msg', [LobbyController::class, 'newMsg']);

Route::post('/draw/lord', [CardsHandler::class, 'drawLord']);
Route::post('/draw/event', [CardsHandler::class, 'drawEvent']);
Route::post('/discard', [CardsHandler::class, 'discard']);

// TEST
Route::get('/endTurn', [TurnsHandler::class, 'endTurn']);






require __DIR__.'/auth.php';
