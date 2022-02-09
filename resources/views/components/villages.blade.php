<div class='locations'>

    <div class='game-board-titles'>
        <span class='crown crown-1'></span>
        <span class='crown crown-2'></span>
        <span class='crown crown-3'></span>
        <span class='crown crown-4'></span>
        <span class='crown crown-5'></span>
        <span class='crown crown-6'></span>
        <span class='crown crown-7'></span>
        <span class='crown crown-8'></span>

        <span class='cross' id='cross-1'></span>
        <span class='cross' id='cross-2'></span>
        <span class='cross' id='cross-3'></span>
        <span class='cross' id='cross-4'></span>
        <span class='cross' id='cross-5'></span>
    </div>

    @foreach($villages as $vilg)

    <?php
        $color = $vilg->player() ? $vilg->player()->color."-bordered" : '';
    ?>

        <span id='{{$vilg->name}}' @class([
            'village',
            "religious-territory-$vilg->cross_zone",
            "$color" => $vilg->player(),
            "empty" => !$vilg->player()
        ])>

            <div class='icons'>
                @if($vilg->isModifiedBy('starvation'))
                    <i class="disas-icon fas fa-water"></i>
                @elseif($vilg->isModifiedBy('storm'))
                    <i class="far fa-snowflake"></i>
                @elseif($vilg->isModifiedBy('plague'))
                    <i class="fas fa-skull-crossbones"></i>
                @elseif($vilg->isModifiedBy('harvest'))
                    <i class="fas fa-sun"></i>
                @elseif($vilg->isModifiedBy('wealth'))
                    <i class="fas fa-sun"></i>
                @endif
            </div>

            <div class='buildings'>
                @foreach($vilg->buildingsHere() as $b)
                    <x-buildings :building="$b" :village="$vilg"/>
                @endforeach
            </div>

            <div class='armies'>
                @if($vilg->soldiers)
                    <x-army :village="$vilg" :families="$families" />
                @endif
            </div>

        </span>

    @endforeach

</div>
