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
        <section class='{{ $currentPlayer->color }}'>Mariages</section>
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

        <section class='players'>

            <div>
            @foreach ($players as $player)
                <div class='player-info-wrapper {{$player->color}}'>
                    <div class='player-name'>{{$player->familyname}}</div>
                </div>
            @endforeach
            </div>

            <button class='end-turn-btn'>Fin du tour</button>

        </section>
        
        
        <section class='main-section'>
                <div class='game-board'>

                    <div class='locations'>

                        <img class='board-img' src='../storage/app/public/images/board.jpg' >
        

                            <span class='city' id='tournus'></span>
                            <span class='village' id='belleville'></span>
                            <span class='village' id='pugnac'></span>
                     
                            <span class='city' id='stgerome'></span>
                            <span class='village' id='stmedard'></span>
                            <span class='village' id='standre'></span>

                            <span class='city' id='bourg'></span>
                            <span class='village' id='villeneuve'></span>
                            <span class='village' id='stvivien'></span>
                            <span class='village' id='labussiere'></span>

                            <span class='village' id='lesessarts'></span>
                            <span class='village' id='stpaul'></span>

                            <span class='city' id='sigy'></span>
                            <span class='village' id='marcamps'></span>
                            <span class='village' id='stciers'></span>

                            <span class='city' id='blaye'></span>
                            <span class='village' id='beaujeu'></span>
                            <span class='village' id='lasalle'></span>
                            <span class='village' id='charolles'></span>

                            <span class='village' id='sennecy'></span>
                            <span class='village' id='lepervier'></span>
                            <span class='village' id='chateauneuf'></span>

                            <span class='village' id='mazilles'></span>
                            <span class='village' id='standromy'></span>

                    </div>

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

                <div class='player-board {{ $color }}'>
                    <div>
                        <button id='make-off'>Off</button>
                        <button id='make-moulin'>Moulins</button>
                        <button id='make-chateau'>Chateau</button>
                        <button id='make-cite'>Cité</button>
                    </div>
                    <div>
                        <button id='moreGold'>+1 G</button>
                        <button id='lessGold'>-1 G</button>
                    </div>
                    <div class='player-hand hand-{{ $handsize }}'>
                        @forelse ($player_cards as $card)
                            <figure class='card'>
                                <img src='{{ $card->img_src }}' id='{{ $card->type }}-{{ $card->name }}'>
                            </figure>
                        @empty
                        @endforelse
                    </div>
                </div>
        </section>            
        
        {{-- <nav class='game-navbar'>
            <button id='bootGame' class='game-nav-btn'>Boot Game</button>
            <button id='drawLord' class='game-nav-btn'>Piocher Lord</button>
            <button id='drawEvent' class='game-nav-btn'>Piocher Event</button>
            <button class='game-nav-btn'>Plateau</button>
            <button class='game-nav-btn'>Joueurs</button>
            <button class='end-turn-btn'>Fin du tour</button>
        </nav> --}}

    </main>

    {{-- <footer>

    </footer> --}}

    <aside class='modal-wrapper' id='info-modal'>
        <div class='modal'>
            <p id='modal-message'></p>
        </div>
    </aside>

</div>
</body>

<script src="{{asset('/js/game.js')}}"></script>

</html>