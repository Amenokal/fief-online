<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fief Online - {{ Auth::user()->username }}</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>    
<div class='game-container'>
    
    <x-header :phases="$phases" :turn="$turn" :currentplayer="$currentPlayer"/>

    <main>

        <div class='main-section'>

            <section class='players'>
                @foreach ($players as $player)
                    <div class='player-info-wrapper {{$player->color}}-bordered'>
                        <div class='player-name'>{{$player->familyname}}</div>
                    </div>
                @endforeach
            </section>
            
            <section class='game-view {{ $currentPlayer->color }}-theme'>
                <div class='game-board'>

                    <x-villages :villages="$villages"
                        :army="$army"
                        :player="$player"
                        :lords="$lords"
                        :buildings="$buildings"
                        :occupied="$occupied"
                    />

                    <x-board-cards :disasters="$inc_disasters" :nextcard="$next_event_card"/>
                    
                </div>
            </section>
            
        </div>
        
        <div class='player-hand hand-{{ $player_cards->count() }}'>
            @foreach ($player_cards as $card)
                <figure class='card'>
                    <img src='{{ $card->img_src }}' id='{{ $card->type }}-{{ $card->name }}'>
                </figure>
            @endforeach
        </div>
        
        <nav>
            <button id='step1'>step 1</button>
            <button id='step2'>step 2</button>
            <button id='moveBtn'>MOVE</button>
            <button id='end-turn'>fin du tour</button>
            <button id='resetDeck'>Reset deck</button>
            <button id='resetBoard'>Reset board</button>
        </nav>


    </main>



    <aside class='modal-wrapper' id='info-modal'>
        <span>RAPPORT DE FORCES</span>
        <div>
            <div class='info-lord'></div>
            <div class='info-soldiers'></div>
        </div>
    </aside>

</div>
</body>

<script src="{{asset('/js/lord-banner.js')}}"></script>
<script src="{{asset('/js/game.js')}}"></script>

</html>