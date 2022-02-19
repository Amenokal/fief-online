<i class="fa-solid fa-square-xmark close-modal-btn"></i>

@if($otherPlayer)
    <section class='other-player-lords {{$otherPlayer->color}}-bordered'>
        @foreach($otherPlayer->lords() as $lord)
            <div class="{{$player->color}}-bordered" id="marry-player{{$player->turn_order}}">
                <span class="modal-card {{$lord->name}}-card"></span>
            </div>
        @endforeach
    </section>

@else
    <section class='other-player-lords'>
        <span>Sélectionnez une famille...</span>
    </section>
@endif

<section class='player-lords {{$localPlayer->color}}-bordered'>
    @foreach ($localPlayer->lords() as $lord)
        <span class="modal-card {{$lord->name}}-card"></span>
    @endforeach
</section>
