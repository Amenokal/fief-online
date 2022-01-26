<section class='lord-slot'>

    <span class='crown'>

    </span>

    <span class='crown'>

    </span>

    <span class='crown'>

    </span>

    @if($player->lords()->skip($i)->first())
        <span
            class="slot player-board-{{$player->lords()->skip($i)->first()->name}}"
            style="background-image: url('/fief/storage/app/public/cards/lords/Eric.png')">
        </span>
    @else
        <span class="slot"></span>
    @endif

    <span class='cross'>

    </span>

    <span class='cross'>

    </span>

    <span class='ring'>

    </span>

</section>
