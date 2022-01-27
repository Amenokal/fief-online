<div class='locations'>

    @foreach($villages as $vilg)

    <?php
        $color = $vilg->player->color ?? '';
    ?>

        <span id='{{$vilg->name}}' @class([
            'village',
            "religious-territory-$vilg->religious_territory",
            "$color-bordered" => $vilg->player,
            "empty" => !$vilg->player
        ])>

            <div class='icons'>
                @if($vilg->isAfflictedBy('Famine'))
                    <i class="disas-icon fas fa-water"></i>
                @elseif($vilg->isAfflictedBy('Mauvais Temps'))
                    <i class="far fa-snowflake"></i>
                @elseif($vilg->isAfflictedBy('Peste'))
                    <i class="fas fa-skull-crossbones"></i>
                @elseif($vilg->isBlessedBy('Bonne Récolte'))
                    <i class="fas fa-sun"></i>
                @elseif($vilg->isBlessedBy('Beau Temps'))
                    <i class="fas fa-sun"></i>
                @endif
            </div>

            <div class='village-buildings'>
                @foreach($vilg->buildingsHere() as $b)
                    <x-buildings :building="$b" :village="$vilg"/>
                @endforeach
            </div>

            @if($vilg->soldiers->isNotEmpty())
                <x-army :village="$vilg" :families="$families" />
            @endif

        </span>

    @endforeach
</div>
