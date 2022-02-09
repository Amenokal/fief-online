<header id='turn-indicator'>

    @foreach($phases as $phase)
        {{-- {{ $turn }} --}}

        <section
            id="phase-{{$phase['id']}}"
            @class(["current-phase $currentplayer->color-bordered" => $phase['id'] === $turn['phase']])
        >

            {{ $phase['name'] }}

        </section>

    @endforeach

</header>
