@foreach ($families as $fam)

    @if($fam->armyHere($village))

        <div class='army {{$fam->color}}'>

            <div class='army-forces'>
                @foreach($fam->lordsHere($village) as $lord)
                    <span id="{{$lord->name}}" class='lord'></span>
                @endforeach

                @foreach($fam->soldiersHere($village) as $soldier)
                    <span class='{{$soldier->type}} token {{$fam->color}}-bordered'></span>
                @endforeach
            </div>


            <div class='move-menu'>
                <i class="move-option inspect fas fa-search"></i>
                <i class="move-option let-one fas fa-male"></i>
                <i class="move-option move-all fas fa-angle-double-right"></i>
                <i class="move-option close fas fa-times-circle"></i>
            </div>

        </div>

    @endif

@endforeach
