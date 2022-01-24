<aside class='player-board {{ $player->color }}-bordered'>

    <section class="family-info">

        {{-- SERGEANTS --}}
        <div>
            @forelse ( $player->remainingSergeants() as $serg )
            <span class="token sergeant {{$player->color}}-bordered"></span>
            @empty
            <span class="token sergeant {{$player->color}}-bordered none"></span>
            @endforelse
        </div>

        {{-- KNIGHTS --}}
        <div>
            @forelse ( $player->remainingKnights() as $knight )
            <span class="token knight {{$player->color}}-bordered"></span>
            @empty
            <span class="token knight {{$player->color}}-bordered none"></span>
            @endforelse
        </div>

        <div>
            <span class="token trebuchet {{$player->color}}-bordered"></span>
        </div>

        <div>
            <span class="token ambassy {{$player->color}}-bordered"></span>
        </div>

        <div>
            <span class="token ring {{$player->color}}-bordered"></span>
        </div>
        <div>
            <span class="token treasure {{$player->color}}-bordered"></span>
            {{$player->gold}}
        </div>
    </section>

    <section class='family-lords'>
        @for($i=0; $i<4; $i++)
            <x-player-board-slot :player="$player" :i="$i"/>
        @endfor
    </section>

</aside>
