<div class='game-cards' id='game-cards'>

    <div class='card-pile lord-discard-pile-wrapper'></div>

    <div class='card-pile lord-pile-wrapper'>
        <figure class='card lord-card'>
            <img src='./storage/images/f.png'>
            <span class='overline'></span>
        </figure>
    </div>

    <div class='card-pile event-pile-wrapper disaster-pile-wrapper'>
            <figure @class([
                "card",
                "event-card" => $next_event_card->disaster,
                "disaster-card" => !$next_event_card->disaster,
            ])>
                <img src='./storage/images/f.png'>
                <span class='overline'>
            </figure>
            <figure class='card disaster-card'>
                <img src='./storage/images/f-w.png'>
                <span class='overline'>
            </figure>
    </div>

    <div class='card-pile incomming-disaster-card-wrapper'>
        @if($disasters>0)
            <figure class='card disaster-card'>
                <img src='./storage/images/f-w.png'>
                <span class='overline'>
            </figure>
        @endif
    </div>
    <div class='card-pile incomming-disaster-card-wrapper'>
        @if($disasters>1)
            <figure class='card disaster-card'>
                <img src='./storage/images/f-w.png'>
                <span class='overline'>
            </figure>
        @endif
    </div>
    <div class='card-pile incomming-disaster-card-wrapper'>
        @if($disasters>2)
            <figure class='card disaster-card'>
                <img src='./storage/images/f-w.png'>
                <span class='overline'>
            </figure>
        @endif
    </div>

    <div class='card-pile event-discard-pile-wrapper'></div>

</div> 