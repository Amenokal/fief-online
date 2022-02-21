<?php

use App\Custom\Phases\DiplomacyPhase;
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
    ->middleware(['auth'])
    ->name('game');

Route::post('/game/update', [GameController::class, 'update'])->middleware(['auth'])->name('update');
Route::post('/player/ready', [GameController::class, 'playerReady'])->middleware(['auth']);




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

Route::post('/check/phase', [TurnController::class, 'giveTurn'])->middleware(['allowed.to.play']);
Route::post('/changeturn', [TurnController::class, 'changeTurn']);
Route::post('/endturn', [TurnController::class, 'endTurn']);

    // SHOW
    // -----

Route::get('/show/board', [GameController::class, 'showBoard']);
Route::get('/show/modal', [GameController::class, 'showModal']);



// PHASES
// ======

Route::post('/game/phase', [PhaseController::class, 'index']);

    // PHASE 0 ::::: GAME START
    // ------------------------

Route::post('/gamestart/0', [GameController::class, 'start']);
Route::post('/gamestart/1', [PhaseController::class, 'getFirstLordsData']);
Route::post('/gamestart/2', [PhaseController::class, 'isItMyTurnToChooseVillage']);
Route::post('/gamestart/3', [PhaseController::class, 'chooseVillage']);

    // PHASE ::::: DIPLOMACY
    // ---------------------

Route::post('/diplo/marriage/init', [PhaseController::class, 'canMarry']);
Route::post('/diplo/marriage/0', [PhaseController::class, 'getOtherLords']);
Route::post('/diplo/marriage/1', [PhaseController::class, 'whithWhoCanMarry']);
Route::post('/diplo/marriage/2', [PhaseController::class, 'sendProposal']);
Route::post('/diplo/marriage/accept', [PhaseController::class, 'acceptProposal']);
Route::post('/diplo/marriage/refuse', [PhaseController::class, 'refuseProposal']);

Route::post('/diplo/bishop/init', [PhaseController::class, 'initBishopElection']);
Route::post('/diplo/bishop/candidat', [PhaseController::class, 'newBishopCandidat']);
Route::post('/diplo/bishop/validate/choice', [PhaseController::class, 'validateChoice']);
Route::post('/diplo/bishop/election', [PhaseController::class, 'startBishopElection']);
Route::post('/diplo/bishop/voted', [PhaseController::class, 'playerVoted']);
Route::post('/diplo/bishop/vote/validated', [PhaseController::class, 'playerVoteValidated']);
Route::post('/diplo/bishop/vote/count', [PhaseController::class, 'voteCount']);
Route::post('/diplo/bishop/next', [PhaseController::class, 'nextBishopElection']);
Route::post('/diplo/bishop/end', [PhaseController::class, 'endBishopElection']);

Route::post('/diplo/pope/init', [PhaseController::class, 'initPopeElection']);

Route::post('/diplo/king/init', [PhaseController::class, 'initKingElection']);



    // PHASE ::::: CARDS
    // -----------------

Route::post('/cards/discard', [CardsController::class, 'discard']);

Route::post('/cards/draw/init', [CardsController::class, 'initDraw']);
Route::post('/cards/draw', [CardsController::class, 'draw']);

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
