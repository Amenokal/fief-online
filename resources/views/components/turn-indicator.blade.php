<header id='turn-indicator'>

    @foreach($phases as $phase)
        @if($phase['id']>1)
            <section
                id="phase-{{$phase['id']}}"
                @class(["current-phase $currentplayer->color-bordered" => $phase['id'] === $turn['phase']])
            >

                {{ $phase['name'] }}

            </section>
        @endif
    @endforeach

</header>
