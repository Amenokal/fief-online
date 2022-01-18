<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\Web\GameController;
use App\Http\Controllers\Game\TurnController;
use App\Http\Controllers\Web\LobbyController;
use App\Custom\Services\GameStartServices;
use App\Http\Controllers\Event\LogEventController;

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

Route::post('/nextturn', [TurnController::class, 'endTurn']);

Route::post('/draw/lord', [CardsController::class, 'drawLord']);
Route::post('/draw/event', [CardsController::class, 'drawEvent']);
Route::post('/discard', [CardsController::class, 'discard']);

Route::post('/gamestart/1', [GameStartServices::class, 'drawFirstLord']);
Route::post('/gamestart/2', [GameStartServices::class, 'chooseVillage']);

// TEST
Route::post('/step3', [TestController::class, 'test3']);
Route::get('/t', [TestController::class, 't']);




require __DIR__.'/auth.php';
