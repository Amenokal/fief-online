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
                @foreach ($families as $fam)
                    <div class='player-info-wrapper {{$fam->color}}-bordered'>
                        <span @class([
                            'player-name',
                            'current-player' => $currentPlayer->id === $fam->id
                        ])>
                            <i class="fas fa-crown"></i>
                            {{$fam->familyname}}
                        </span>
                        <div class='player-info'>
                            <p>Points: 0</p>
                            <p>Or: {{$fam->gold}}</p>
                        </div>
                    </div>
                @endforeach

                <nav>
                    <div class='starter-phase-btns'>
                        <h2>STARTER PHASE</h2>
                        <div>
                            <button id='step1'>Premier seigneur</button>
                            <button id='step2'>Emplacement de départ</button>
                        </div>
                    </div>
                    <div class='move-btns'>
                        <h2>MOUVEMENT</h2>
                        <div>
                            <button id='moveBtn'>MOVE</button>
                        </div>
                    </div>
                    <div class='building-btns'>
                        <h2>BUY</h2>
                        <div>
                            <button class='moulin' id='buyBtn-moulin'></button>
                            <button class='token sergeant' id='buyBtn-sergeant'></button>
                            <button class='token knight' id='buyBtn-knight'></button>
                        </div>
                    </div>
                    <div class='turn-btns'>
                        <h2>TOUR</h2>
                        <div>
                            <button id='disasters-btn'>calamités</button>
                            <button id='end-turn'>fin du tour</button>
                        </div>
                    </div>
                    <div class='reset-btns'>
                        <h2>RESETS</h2>
                        <div>
                            <button id='resetDeck'>Reset deck</button>
                            <button id='resetBoard'>Reset board</button>
                        </div>
                    </div>
                </nav>

            </section>

            <section class='game-view {{ $currentPlayer->color }}-theme'>
                <div class='game-board'>

                    <x-villages
                        :villages="$villages"
                        :army="$army"
                        :player="$player"
                        :lords="$lords"
                        :buildings="$buildings"
                        :families="$families"
                    />

                    <div class='game-board-info'>

                        <x-board-info
                            :nextlord="$next_lord_card"
                            :nextevent="$next_event_card"
                            :disasters="$inc_disasters"
                            :lorddiscard="$lord_discard_pile"
                            :eventdiscard="$event_discard_pile"
                            :lords="$remaining_lords"
                            :buildings="$remaining_buildings"
                        />

                    </div>


                </div>
            </section>

        </div>

        <aside class='player-hand hand-{{$player_cards->count()}}'>
            @foreach ($player_cards as $card)
                <span
                    draggable="true"
                    class='card'
                    id='{{ $card->deck }}-{{ $card->name }}'
                    style='background-image: url({{ $card->img_src }})'
                ></span>
            @endforeach
        </aside>

    </main>

</div>
</body>

<script src="{{asset('/js/game.js')}}"></script>

</html>
