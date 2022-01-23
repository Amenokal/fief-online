<aside class='player-board {{ $player->color }}-bordered'>

    @for($i=0; $i<4; $i++)
        <x-player-board-slot :player="$player" :i="$i"/>
    @endfor

    <section class='info'></section>
</aside>
