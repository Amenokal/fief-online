<div class='remaining-buildings'>
    <div>
        @foreach ($buildings as $b)
            @if($b->name === 'moulin')
                <span class='remaining-{{$b->name}}'></span>
            @endif
        @endforeach
    </div>
    <div>
        @foreach ($buildings as $b)
            @if($b->name === 'chateau')
                <span class='remaining-{{$b->name}}'></span>
            @endif
        @endforeach

    </div>
</div>

<div class='remaining-lords'>
    @foreach ($lords as $lord)
        <span class='remaining-lord-{{$lord->name}}'></span>
    @endforeach
</div>

<div class='game-cards'>

    @if($lorddiscard->isNotEmpty())
        @foreach($lorddiscard as $card)
            <span class='card lord-verso discarded-lord'></span>
        @endforeach
    @else
        <span class='card-pile'></span>
    @endif


    @if($nextlord->exists())
        <span class='card-pile lord-verso' id='nextLordCard'></span>
    @else
        <span class='card-pile'>
            <i class="fas fa-sync" id='shuffleLord'></i>
        </span>
    @endif


    @if($nextevent->exists())
        <span id='nextEventCard' @class([
            "card-pile",
            "event-verso" => !$nextevent->disaster,
            "disaster-verso" => $nextevent->disaster
        ])></span>
    @else
        <span class='card-pile'>
            <i class="fas fa-sync" id='shuffleEvent'></i>
        </span>
    @endif


    @for($i=0; $i<3; $i++)
        @if($i<$disasters)
            <span class='card disaster-card' id='incDisas-{{$i}}'></span>
        @else
            <span class='card-pile' id='incDisasPile-{{$i}}'></span>
        @endif
    @endfor


    @if($eventdiscard->isNotEmpty())
        @foreach($eventdiscard as $card)
            <span @class([
                'card',
                'discarded-event',
                "event-verso" => !$card->disaster,
                "disaster-verso" => $card->disaster
            ])></span>
        @endforeach
    @else
        <span class='card-pile'></span>
    @endif

</div>

<div class='game-info-tokens'></div>

<div class='game-info-cards'></div>
