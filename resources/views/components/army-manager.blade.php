<aside class='modal army-manager'>

    <section class='a-m-village'>

        <h1>{{ $village->name }}</h1>

        <div>

            <div class='a-m-staying-lords'>
                @foreach ( $player->lordsHere($village) as $lord )
                    <span class='lord' id="{{$lord->name}}"></span>
                @endforeach
            </div>

            <div class='a-m-staying-army'>
                @foreach ( $player->sergeantsHere($village) as $serg )
                    <span class='{{ $serg->type }} token {{$player->color}}-bordered'></span>
                @endforeach

                @foreach ( $player->knightsHere($village) as $knight )
                    <span class='{{ $knight->type }} token {{$player->color}}-bordered'></span>
                @endforeach
            </div>

        </div>

        <button id='a-m-cancel-btn'>Annuler</button>


    </section>

    <section class='a-m-army'>
        <h1>
            DÉTACHEMENT
        </h1>
        <div>

            <div class='a-m-moving-lords'></div>
            <div class='a-m-moving-army'></div>

        </div>

        <button id='a-m-validate-btn'>Valider</button>

    </section>

</aside>
