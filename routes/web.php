<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Web\GameController;
use App\Http\Controllers\Game\TurnController;
use App\Http\Controllers\Web\LobbyController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Game\CardsController;
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

Route::get('/', [LoginController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'connect'])->name('login');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'createUser']);

Route::get('/game', [GameController::class, 'index'])
    ->middleware([
        'auth',
        'connect.to.game',
        'create.game'
    ])
    ->name('game');

Route::post('/game/update', [GameController::class, 'update'])->middleware(['auth'])->name('update');




// ::: EVENTS :::
// ==============

    // LOG EVENTS
    // ----------

// Route::get('/log/in', [LogEventController::class, 'login']);
// Route::get('/log/out', [LogEventController::class, 'logout']);

    // LOBBY EVENTS
    // ------------

// Route::get('/lobby/connect', [LobbyController::class, 'connectToGame']);
// Route::get('/lobby/ready', [LobbyController::class, 'isReady']);
// Route::post('/lobby/msg', [LobbyController::class, 'newMsg']);



// ::: GAME :::
// ============

    // META
    // ====

Route::post('/reset/deck', [TestController::class, 'resetCards']);
Route::post('/reset/board', [TestController::class, 'resetBoard']);

    // TURNS
    // -----

Route::post('/check/phase', [TurnController::class, 'giveTurn']);
Route::post('/changeturn', [TurnController::class, 'changeTurn']);
Route::post('/endturn', [TurnController::class, 'endTurn']);

    // PLAYER BOARDS
    // -------------

Route::get('/show/board', [GameController::class, 'showBoard']);



// PHASES
// ======

Route::post('/game/phase', [PhaseController::class, 'index']);

    // PHASE 0 ::::: GAME START
    // ------------------------

Route::post('/gamestart/0', [GameController::class, 'start'])->name('game-start');
Route::post('/gamestart/1', [PhaseController::class, 'drawFirstLord']);
Route::post('/gamestart/2', [PhaseController::class, 'chooseVillage']);

    // PHASE ::::: CARDS
    // -----------------

Route::post('/draw/card', [CardsController::class, 'draw']);
Route::post('/discard', [CardsController::class, 'discard']);
Route::post('/shuffle', [CardsController::class, 'shuffle']);

Route::get('/disasters/show', [CardsController::class, 'showDisasters']);

Route::post('/play/lord', [CardsController::class, 'playLord']);
Route::post('/play/add/wealth', [CardsController::class, 'addWealth']);
Route::post('/play/remove/disaster', [CardsController::class, 'removeDisaster']);

    // PHASE ::::: GOLD
    // ----------------

Route::post('/gold/income', [PhaseController::class, 'getIncome']);

Route::post('/gold/buy/mill', [PhaseController::class, 'buyMill']);
Route::post('/gold/buy/castle', [PhaseController::class, 'buyCastle']);
Route::post('/gold/buy/sergeant', [PhaseController::class, 'buySergeant']);
Route::post('/gold/buy/knight', [PhaseController::class, 'buyKnight']);
Route::post('/gold/buy/crown', [PhaseController::class, 'buyTitle']);

    // PHASE 11 ::::: MOVE
    // -------------------

Route::post('/move/moveall', [PhaseController::class, 'moveAll']);
Route::post('/move/letone', [PhaseController::class, 'letOne']);
Route::post('/move/inspect', [PhaseController::class, 'inspect']);
Route::get('/show/army/manager', [PhaseController::class, 'showArmyManager']);

// require __DIR__.'/auth.php';
