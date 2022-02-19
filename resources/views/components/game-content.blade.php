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

            <x-player-actions :phase="$turn['phase']"/>

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
