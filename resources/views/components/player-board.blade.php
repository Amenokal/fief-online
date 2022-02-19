<aside class='modal player-board {{ $player->color }}-bordered'>

    <section class="family-info">

        {{-- SERGEANTS --}}
        <div class="token-pool">
            @foreach($sergLeft as $serg)
                <span @class([
                    "token",
                    "sergeant",
                    $player->color."-bordered",
                    "none" => $sergLeft->count() === 0
                ])></span>
            @endforeach
        </div>

        {{-- KNIGHTS --}}
        <div class="token-pool">
            @foreach($knightLeft as $knight)
                <span @class([
                    "token",
                    "knight",
                    $player->color."-bordered",
                    "none" => $knightLeft->count() === 0
                ])></span>
            @endforeach
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
