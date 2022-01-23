@foreach ($families as $fam)

@if($fam->lordsHere($village)->isNotEmpty() || $fam->sergeantsHere($village) || $fam->knightsHere($village))

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

    {{-- <canvas height="400px" width="250px" class='banner {{$fam->color}} power-{{$fam->lordsHere($village)->first()->army_power()}}'></canvas> --}}

    <div class='army-forces'>
        <div class='sergeant-container'>
            @for($i=0; $i<count($fam->sergeantsHere($village)); $i++)
               <span class='sergeant token {{$fam->color}}-bordered'></span>
            @endfor
        </div>

        <div class='knight-container'>
            @for($i=0; $i<count($fam->knightsHere($village)); $i++)
                <span class='knight token {{$fam->color}}-bordered'></span>
            @endfor
        </div>
    </div>
    

</div>

@endif

@endforeach