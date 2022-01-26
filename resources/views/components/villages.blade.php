<div class='locations'>

    @foreach($villages as $vilg)

    <?php
        $color = $vilg->player->color ?? '';
    ?>

        <span id='{{$vilg->name}}' @class([
            'village',
            "$color-bordered" => $vilg->player,
            "empty" => !$vilg->player
        ])>

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
