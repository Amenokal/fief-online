<x-turn-indicator :phases="$phases" :turn="$turn" :currentplayer="$currentplayer"/>

<main>

    <div class='main-section'>

        <section class='players'>

            @foreach ($families->sortBy('turn_order')->all() as $fam)
                <x-player-info
                    :fam="$fam"
                    :currentplayer="$currentplayer"
                />
            @endforeach

            <nav>
                <div class='move-btns'>
                    <h2>ACTIONS</h2>
                    <div>
                        <button id='moveBtn'>Move</button>
                        <button id='disasters-btn'>Calamités</button>
                        <button id='income-btn'>Revenus</button>
                    </div>
                </div>
                <div class='building-btns'>
                    <h2>BUY</h2>
                    <div>
                        <button class='moulin' id='buyBtn-moulin'></button>
                        <button class='token sergeant' id='buyBtn-sergeant'></button>
                        <button class='crown' id='buyBtn-crown'></button>
                        <button class='chateau' id='buyBtn-chateau'></button>
                        <button class='token knight' id='buyBtn-knight'></button>
                        <button class='cardinal' id='buyBtn-cardinal'></button>
                    </div>
                </div>
                <div class='reset-btns'>
                    <h2>OPTIONS</h2>
                    <div>
                        <button id='end-turn'>Fin du tour</button>
                        <button id='fullScreen'>FullScreen</button>
                        <button id='resetAll'>Reset</button>
                    </div>
                </div>
            </nav>

        </section>

        <section class='game-view {{ $player->color }}-theme'>
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
                        :nextlord="$nextlord"
                        :nextevent="$nextevent"
                        :disasters="$disasters"
                        :lorddiscard="$lorddiscard"
                        :eventdiscard="$eventdiscard"
                        :remnlords="$remnlords"
                        :remnbuildings="$remnbuildings"
                    />

                </div>

            </div>
        </section>

        <aside class='player-hand hand-{{$playercards->count()}}'>
            @foreach ($playercards as $card)
                @if(!$card->on_board)
                    <span draggable="true" class="card {{$card->name}}-card"></span>
                @endif
            @endforeach
        </aside>

    </div>


</main>
