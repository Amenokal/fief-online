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

            @foreach($buildings as $b)
                @if($b->village_id === $vilg->id)
                    <span class="{{$b->name}}"></span>
                @endif
            @endforeach

            @if($vilg->soldiers->isNotEmpty())
                <x-army :village="$vilg" :families="$families" />
            @endif

        </span>

    @endforeach
</div>
