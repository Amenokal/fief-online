<?php $disaster = 'event'; $isD = true?>

<div class='game-cards' id='game-cards'>

    {{-- ::: LORD DISCARD PILE ::: --}}
    <div class='card-pile' id='lord-discardPile'>
        @foreach($lorddiscard as $card)
            <x-card-verso :type="$lorddiscard[0]->deck" :disaster="$lorddiscard[0]->disaster" />
        @endforeach
    </div>


    {{-- ::: LORD DRAW PILE ::: --}}
    <div class='card-pile' id='lord-drawPile'>
        @if($nextlordcard)
            <x-card-verso :type="$nextlordcard->deck" :disaster="$nextlordcard->disaster"/>
        @else
            <i class="fas fa-sync" id='shuffle-lord'></i>
        @endif
    </div>


    {{-- ::: EVENT DRAW PILE ::: --}}
    <div class='card-pile' id='event-drawPile'>
        @if($nexteventcard)
            <x-card-verso :type="$nexteventcard->deck" :disaster="$nexteventcard->disaster" />
        @else
            <i class="fas fa-sync" id='shuffle-event'></i>
        @endif
    </div>


    {{-- ::: INCOMMING DISASTERS PILES ::: --}}
    <div class='card-pile' id='incDisasPile1'>
        @if($disasters>0)
            <x-card-verso :type="$disaster" :disaster="$isD" />
        @endif
    </div>
    <div class='card-pile' id='incDisasPile2'>
        @if($disasters>1)
            <x-card-verso :type="$disaster" :disaster="$isD" />
        @endif
    </div>
    <div class='card-pile' id='incDisasPile3'>
        @if($disasters>2)
            <x-card-verso :type="$disaster" :disaster="$isD" />
        @endif
    </div>


    {{-- ::: DISCARD EVENT PILE ::: --}}
    <div class='card-pile' id='event-discardPile'>
        @foreach($eventdiscard as $card)
            <x-card-verso :type="$eventdiscard[0]->deck" :disaster="$eventdiscard[0]->disaster"/>
        @endforeach
    </div>

</div>
