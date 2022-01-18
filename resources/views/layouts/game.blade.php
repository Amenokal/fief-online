<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fief Online - {{ Auth::user()->username }}</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>

<body>    
<div class='game-container'>
    
    <header>
        <section class='current {{ $currentPlayer->color }}-bordered'>Mariages</section>
        <section>Élection Évêques</section>
        <section>Élection du Pape</section>
        <section>Élection du Roi</section>
        <section>Défausse</section>
        <section>Pioche</section>
        <section>Calamité</section>
        <section>Pose</section>
        <section>Revenus</section>
        <section>Dépenses</section>
        <section>Mouvements</section>
        <section>Batailles</section>
        <section>Pillages</section>
    </header>

    <main>

        <div class='main-section'>
        <section class='players'>

            <div>
            @foreach ($players as $player)
                <div class='player-info-wrapper {{$player->color}}-bordered'>
                    <div class='player-name'>{{$player->familyname}}</div>
                </div>
            @endforeach
            </div>

            <button class='end-turn-btn'>Fin du tour</button>

        </section>
        
        <section class='game-view {{ $currentPlayer->color }}-theme'>
                <div class='game-board'>

                    <x-villages :villages="$villages"
                        :army="$army"
                        :player="$player"
                        :lords="$lords"
                        :buildings="$buildings"
                    />


                    <div class='game-cards' id='game-cards'>

                        <div class='card-pile lord-discard-pile-wrapper'></div>

                        <div class='card-pile lord-pile-wrapper'>
                            <figure class='card lord-card'>
                                <img src='./storage/images/f.png'>
                                <span class='overline'></span>
                            </figure>
                        </div>

                        <div class='card-pile event-pile-wrapper disaster-pile-wrapper'>
                            @if($next_event_card === 'event')
                                <figure class='card event-card'>
                                    <img src='./storage/images/f.png'>
                                    <span class='overline'>
                                </figure>
                            @elseif($next_event_card === 'disaster')
                                <figure class='card disaster-card'>
                                    <img src='./storage/images/f-w.png'>
                                    <span class='overline'>
                                </figure>
                            @endif
                        </div>
    
                        <div class='card-pile incomming-disaster-card-wrapper'>
                            @if($inc_disasters>0)
                                <figure class='card disaster-card'>
                                    <img src='./storage/images/f-w.png'>
                                    <span class='overline'>
                                </figure>
                            @endif
                        </div>
                        <div class='card-pile incomming-disaster-card-wrapper'>
                            @if($inc_disasters>1)
                                <figure class='card disaster-card'>
                                    <img src='./storage/images/f-w.png'>
                                    <span class='overline'>
                                </figure>
                            @endif
                        </div>
                        <div class='card-pile incomming-disaster-card-wrapper'>
                            @if($inc_disasters>2)
                                <figure class='card disaster-card'>
                                    <img src='./storage/images/f-w.png'>
                                    <span class='overline'>
                                </figure>
                            @endif
                        </div>

                        <div class='card-pile event-discard-pile-wrapper'></div>

                    </div> 


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
            <button id='step1'>1</button>
            <button id='step2'>2</button>
            <button id='step3'>3</button>
            <button></button>
            <button></button>
            <button></button>
            <button></button>
        </nav>


    </main>


    <aside class='modal-wrapper' id='info-modal'>
        <div class='modal'>
            <p id='modal-message'></p>
        </div>
    </aside>

</div>
</body>

<script src="{{asset('/js/lord-banner.js')}}"></script>
<script src="{{asset('/js/game.js')}}"></script>

</html>