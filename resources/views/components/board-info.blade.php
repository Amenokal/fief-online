<div class='remaining-buildings'>
    <div>
        @foreach ($remnbuildings as $b)
            @if($b->name === 'moulin')
                <span class='remaining-{{$b->type}}'></span>
            @endif
        @endforeach
    </div>
    <div>
        @foreach ($remnbuildings as $b)
            @if($b->name === 'chateau')
                <span class='remaining-{{$b->type}}'></span>
            @endif
        @endforeach

    </div>
</div>

<div class='remaining-lords'>
    @foreach ($remnlords as $lord)
        @if($lord->name !== 'Cardinal' && $lord->name !== "d'Arc")
            <span class='{{$lord->name}}-token'></span>
        @endif
    @endforeach
</div>



{{-- ::::: GAME CARDS ::::: --}}
<div class='game-cards'>

    <div class='card-pile' id='lordDiscardPile'>
        @if($lorddiscard->isNotEmpty())
            @foreach($lorddiscard as $card)
                <span class='card lord-verso'></span>
            @endforeach
        @endif
    </div>


    <div class='card-pile' id='lordCardPile'>
        @if($nextlord->exists())
            <span class='card lord-verso can-draw'></span>
        @else
            <i class="fas fa-sync" id='shuffleLord'></i>
        @endif
    </div>


    <div class='card-pile' id='eventCardPile'>
        @if($nextevent->exists())
            <span @class([
                "card",
                "can-draw",
                "event-verso" => !$nextevent->disaster,
                "disaster-verso" => $nextevent->disaster
            ])>
            </span>
        @else
            <i class="fas fa-sync" id='shuffleEvent'></i>
        @endif
    </div>



    @for($i=0; $i<3; $i++)
        <div class='card-pile inc-disas' id='incDisas-{{$i}}'>
            @if(!!$disasters->skip($i)->first())
                @if(!!$disasters->skip($i)->first()->cross_id)
                    <div class='card disaster-recto {{$disasters->skip($i)->first()->name}}' style="background-image: url({{$disasters->skip($i)->first()->img_src}})"></div>
                @else
                    <div class='card disaster-verso'></div>
                @endif
            @endif
        </div>
    @endfor


    <div class='card-pile' id='eventDiscardPile'>
        @if($eventdiscard->isNotEmpty())
            @foreach($eventdiscard as $card)
                <span @class([
                    'card',
                    "event-verso" => !$card->disaster,
                    "disaster-verso" => $card->disaster
                ])></span>
            @endforeach
        @endif
    </div>


</div>

<div class='game-info-tokens'>
    <span class='cardinal'></span>
    <span class='cardinal'></span>
    <span class='cardinal'></span>
    <span class='cardinal payed-cross'></span>
    <span class='arc'></span>
</div>

<div class='game-info-cards'></div>
