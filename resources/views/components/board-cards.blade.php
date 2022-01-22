<?php
    $disaster = 'event';
    $isdisaster = true;
?>

<div class='game-cards' id='game-cards'>

    <div class='card-pile lord-discard-pile-wrapper' id='lord-discardPile'>
        @foreach($lorddiscard as $card)
            <x-card-verso :type="$card->deck" />
        @endforeach
    </div>

    <div class='card-pile lord-pile-wrapper' id='lord-drawPile'>
        @if($nextlordcard)
            <x-card-verso :type="$nextlordcard->deck" />
        @endif
    </div>

    <div class='card-pile event-pile-wrapper disaster-pile-wrapper' id='event-drawPile'>
        @if($nexteventcard)
            <x-card-verso :type="$nexteventcard->deck" :disaster="$nexteventcard->disaster" />
        @endif
    </div>

    <div class='card-pile incomming-disaster-card-wrapper' id='incDisasPile1'>
        @if($disasters>0)
            <x-card-verso :type="$disaster" :disaster="$isdisaster"/>
        @endif
    </div>
    <div class='card-pile incomming-disaster-card-wrapper' id='incDisasPile2'>
        @if($disasters>1)
            <x-card-verso :type="$disaster" :disaster="$isdisaster"/>
        @endif
    </div>
    <div class='card-pile incomming-disaster-card-wrapper' id='incDisasPile3'>
        @if($disasters>2)
            <x-card-verso :type="$disaster" :disaster="$isdisaster"/>
        @endif
    </div>

    <div class='card-pile event-discard-pile-wrapper' id='event-discardPile'>
        @foreach($eventdiscard as $card)
            <x-card-verso :type="$eventdiscard->deck" :disaster="$eventdiscard->disaster"/>
        @endforeach
    </div>

</div> 