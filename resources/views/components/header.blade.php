<header>

    @foreach($phases as $phase)

        <section @class([
            '{{ $currentplayer->color }}-bordered'
        ])>
            {{ $phase->name }}
        </section>

    @endforeach

</header>