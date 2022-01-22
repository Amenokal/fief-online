<header id='turn-indicator'>

    @foreach($phases as $phase)

        <section
            id="phase-{{$phase['id']}}" 
            @class([
                "current-phase" => $phase['id'] === $turn['phase'],
                "$currentplayer->color-bordered" => $phase['id'] === $turn['phase']
            ])
        >

            {{ $phase['name'] }}

        </section>

    @endforeach

</header>