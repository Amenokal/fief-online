<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Game\CardsController;
use App\Http\Controllers\Web\GameController;
use App\Http\Controllers\Game\TurnController;
use App\Http\Controllers\Web\LobbyController;
use App\Http\Controllers\Game\PhaseController;
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

// ::: WEB :::
// ===========

Route::get('/', function () { return view('auth.login'); })->name('home');
Route::get('/lobby', [LobbyController::class, 'index'])->middleware(['auth'])->name('menu');
Route::get('/game', [GameController::class, 'index'])->middleware(['auth'])->name('game');




// ::: EVENTS :::
// ==============

    // LOG EVENTS
    // ----------

Route::get('/log/in', [LogEventController::class, 'login']);
Route::get('/log/out', [LogEventController::class, 'logout']);

    // LOBBY EVENTS
    // ------------

Route::get('/lobby/connect', [LobbyController::class, 'connectToGame']);
Route::get('/lobby/ready', [LobbyController::class, 'isReady']);
Route::post('/lobby/msg', [LobbyController::class, 'newMsg']);




// ::: GAME :::
// ============

// META
// ====

Route::post('/reset/deck', [TestController::class, 'resetCards']);
Route::post('/reset/board', [TestController::class, 'resetBoard']);

    // DRAW
    // ----



    // TURNS
    // -----

Route::post('/changeturn', [TurnController::class, 'changeTurn']);
Route::post('/endturn', [TurnController::class, 'endTurn']);

    // PLAYER BOARDS
    // -------------

Route::get('/show/board', [GameController::class, 'showBoard']);




// PHASES
// ======

    // PHASE 0 ::::: GAME START
    // ------------------------

Route::post('/gamestart/1', [PhaseController::class, 'drawFirstLord']);
Route::post('/gamestart/2', [PhaseController::class, 'chooseVillage']);

    // PHASE ::::: CARDS
    // -----------------

Route::post('/draw/card', [CardsController::class, 'draw']);
Route::post('/discard', [CardsController::class, 'discard']);
Route::post('/shuffle', [CardsController::class, 'shuffle']);
Route::get('/disasters/show', [CardsController::class, 'showDisasters']);

Route::post('/play/add/wealth', [CardsController::class, 'addWealth']);
Route::post('/play/remove/disaster', [CardsController::class, 'removeDisaster']);

    // PHASE ::::: GOLD
    // ----------------

Route::post('/gold/buy', [PhaseController::class, 'buyBuilding']);

    // PHASE 11 ::::: MOVE
    // -------------------

Route::post('/move/moveall', [PhaseController::class, 'moveAll']);
Route::post('/move/letone', [PhaseController::class, 'letOne']);
Route::get('/show/army/manager', [PhaseController::class, 'showArmyManager']);
Route::post('/move/inspect', [PhaseController::class, 'inspect']);




Route::get('/t', [PhaseController::class, 'buyBuilding']);

require __DIR__.'/auth.php';
