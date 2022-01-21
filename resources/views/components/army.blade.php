@forelse ($families as $fam)

@if($fam->lordsHere($village)->isNotEmpty())

<div class='army'>

    <div class='lord-forces'>
        @foreach($fam->lordsHere($village) as $lord)
            <span id="{{$lord->name}}" class='lord'></span>
        @endforeach
    </div>
        
    <div class='move-options'>
        <i id='move-option-inspect' class="fas fa-search"></i>
        <i id='move-option-let-one' class="fas fa-male"></i>
        <i id='move-option-move-all' class="fas fa-angle-double-right"></i>
        <i id='move-option-close' class="fas fa-times-circle"></i>
    </div>

    <canvas height="400px" width="250px" class='banner {{$fam->color}} power-{{$fam->lordsHere($village)->first()->army_power()}}'></canvas>

    <div class='army-forces'>
        <span class='sergeant token {{$fam->color}}-bordered'>{{$fam->lordsHere($village)->first()->army()['sergeants']}}</span>
        <span class='knight token {{$fam->color}}-bordered'>{{$fam->lordsHere($village)->first()->army()['knights']}}</span>
    </div>
    

</div>

@endif

@empty
@endforelse