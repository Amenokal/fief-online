<div class='locations'>

    <div class='game-board-titles'>
        <span class='crown crown-1 can-take'></span>
        <span class='crown crown-2 can-take'></span>
        <span class='crown crown-3 can-take'></span>
        <span class='crown crown-4 can-take'></span>
        <span class='crown crown-5 can-take'></span>
        <span class='crown crown-6 can-take'></span>
        <span class='crown crown-7 can-take'></span>
        <span class='crown crown-8 can-take'></span>

        <span class='cross can-take' id='cross-1'></span>
        <span class='cross can-take' id='cross-2'></span>
        <span class='cross can-take' id='cross-3'></span>
        <span class='cross can-take' id='cross-4'></span>
        <span class='cross can-take' id='cross-5'></span>
    </div>

    @foreach($villages as $vilg)

    <?php
        $color = $vilg->player() ? $vilg->player()->color."-bordered" : '';
    ?>

        <span id='{{$vilg->name}}' @class([
            'village',
            "cross-zone-$vilg->cross_zone",
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
