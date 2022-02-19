<header id='turn-indicator'>

    @foreach($phases as $phase)
        @if($phase['id']>1)
            <section
                id="phase-{{$phase['id']}}"
                @class(["current-phase $currentplayer->color-theme" => $phase['id'] === $turn['phase']])
            >

                <span class='turn-icon'>
                    @if($phase['id'] === 6)
                        <i class="fa-solid fa-xmark"></i>
                    @elseif($phase['id'] === 7)
                        <i class="fa-solid fa-plus"></i>
                    @elseif($phase['id'] === 9 || $phase['id'] === 10 || $phase['id'] === 11)
                        <i class="fa-solid fa-share"></i>
                    @elseif($phase['id'] === 12)
                        <i class="fa-solid fa-chevron-right"></i>
                        <i class="fa-solid fa-chevron-right"></i>
                    @elseif($phase['id'] === 13)
                        <span class='turn-dices'></span>
                    @endif
                </span>



            </section>
        @endif
    @endforeach

</header>
