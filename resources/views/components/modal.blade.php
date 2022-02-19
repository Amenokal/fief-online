<div @class([
    'modal',
    'marriage-modal' => $phase === 2
])>

    <div class='parchm-top'>

        <i class="fa-solid fa-square-xmark close-modal-btn"></i>

        @if($phase === 2)

            <section class='player-lords {{$localPlayer->color}}-bordered'>
                @foreach ($localPlayer->lords() as $lord)
                    <span class="{{$lord->name}}-card"></span>
                @endforeach
            </section>

            @if($otherPlayer)
                <section class='other-player-lords {{$otherPlayer->color}}-bordered'>
                    @foreach($otherPlayer->lords() as $lord)
                        <div class="{{$player->color}}-bordered" id="marry-player{{$player->turn_order}}">
                            <span class="{{$lord->name}}-card"></span>
                        </div>
                    @endforeach
                </section>

            @else
                <section class='other-player-lords'>
                    <span>Sélectionnez une famille...</span>
                </section>
            @endif



        @endif

    </div>

    <span class='parchm-bottom'>
        <button class='modal-btn'>Proposer un marriage</button>
    </span>
</div>
