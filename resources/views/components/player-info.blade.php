<div class='player-info-wrapper {{$fam->color}}-bordered'>
    <span @class([
        'player-name',
        'current-player' => $currentplayer->id === $fam->id
    ])>
        {{-- <i class="fas fa-crown"></i> --}}
        {{$fam->family_name}}
    </span>
    <div class='player-info'>
        <p>Points: 0</p>
        <p>Or: {{$fam->gold}}</p>
    </div>
</div>
