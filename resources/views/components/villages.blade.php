<div class='locations'>

    <div class='game-board-titles'>
        <span class='crown crown-1'>1</span>
        <span class='crown crown-2'>2</span>
        <span class='crown crown-3'>3</span>
        <span class='crown crown-4'>4</span>
        <span class='crown crown-5'>5</span>
        <span class='crown crown-6'>6</span>
        <span class='crown crown-7'>7</span>
        <span class='crown crown-8'>8</span>

        <span class='cross' id='cross-1'>1</span>
        <span class='cross' id='cross-2'>2</span>
        <span class='cross' id='cross-3'>3</span>
        <span class='cross' id='cross-4'>4</span>
        <span class='cross' id='cross-5'>5</span>
    </div>

    @foreach($villages as $vilg)

    <?php
        $color = $vilg->owner()->color ?? '';
    ?>

        <span id='{{$vilg->name}}' @class([
            'village',
            "religious-territory-$vilg->religious_territory",
            "$color-bordered" => $vilg->owner(),
            "empty" => !$vilg->owner()
        ])>

            <div class='icons'>
                @if($vilg->isModifiedBy('Famine'))
                    <i class="disas-icon fas fa-water"></i>
                @elseif($vilg->isModifiedBy('Mauvais Temps'))
                    <i class="far fa-snowflake"></i>
                @elseif($vilg->isModifiedBy('Peste'))
                    <i class="fas fa-skull-crossbones"></i>
                @elseif($vilg->isModifiedBy('Bonne Récolte'))
                    <i class="fas fa-sun"></i>
                @elseif($vilg->isModifiedBy('Beau Temps'))
                    <i class="fas fa-sun"></i>
                @endif
            </div>

            <div class='buildings'>
                @foreach($vilg->buildingsHere() as $b)
                    <x-buildings :building="$b" :village="$vilg"/>
                @endforeach
            </div>

            <div class='armies'>
                @if($vilg->soldiers->isNotEmpty() || $vilg->lords()->exists())
                    <x-army :village="$vilg" :families="$families" />
                @endif
            </div>

        </span>

    @endforeach

</div>
