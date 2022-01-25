@foreach ($families as $fam)

@if($fam->lordsHere($village) || $fam->armyHere($village))

<div class='army {{$fam->color}}'>

    <div class='lord-forces'>
        @foreach($fam->lordsHere($village) as $lord)
            <span id="{{$lord->name}}" class='lord'></span>
        @endforeach
    </div>

    <div class='move-menu'>
        <i class="move-option inspect fas fa-search"></i>
        <i class="move-option let-one fas fa-male"></i>
        <i class="move-option move-all fas fa-angle-double-right"></i>
        <i class="move-option close fas fa-times"></i>
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
