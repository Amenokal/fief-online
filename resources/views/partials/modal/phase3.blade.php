
<div class='election-container'>
    <span class='cross-election'></span>

    <div>
        <section class='other-lords'>
            @foreach ($players as $player)
                <div class="{{$player->color}}-bordered not-decided"></div>
            @endforeach
        </section>

        <section class="{{$localPlayer->color}}-bordered">
            <div class="{{Auth::user()->player->color}}-themed my-lords not-decided">
                @forelse ($bishopLords as $lord)
                    <span class="modal-card {{$lord->name}}-card"></span>
                @empty
                    <span class='no-bishop'>Vous n'avez pas de seigneur éligible</span>
                @endforelse
            </div>
        </section>

    </div>
</div>
