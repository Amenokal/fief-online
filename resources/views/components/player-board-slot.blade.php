<?php $lord = $player->lords()->skip($i)->first()?>

<section class='lord-slot'>

    @for ($j=0; $j<3; $j++)
        <span class='crown-slot'>

            @if($lord && $lord->isTitled() && $lord->titles()->skip($j)->first())
                <span @class([
                    'crown-slot',
                    'crown'=>$lord && $lord->isTitled() && $lord->titles()->skip($j)->first()
                ])>
                    {{$lord->title()->skip($j)->first()->zone}}
                </span>
            @endif

        </span>
    @endfor

    @if($lord && $lord->on_board)
        <span class="slot {{$lord->name}}-card"></span>
    @else
        <span class="slot"></span>
    @endif

    <span class='cross-slot'></span>
    <span class='cross-slot'></span>

    <span class='ring'></span>

</section>
