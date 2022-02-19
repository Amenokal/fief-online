@extends('../layouts/game')

@section('content')

<header id='turn-indicator'>

    @foreach($phases as $phase)
        @if($phase['id']>1)
            <section
                id="phase-{{$phase['id']}}"
            >

                <span class='turn-icon'>
                    @if($phase['id'] === 6)
                        <i class="fa-solid fa-xmark"></i>
                    @elseif($phase['id'] === 7)
                        <i class="fa-solid fa-plus"></i>
                    @elseif($phase['id'] === 9 || $phase['id'] === 10 || $phase['id'] === 11)
                        <i class="fa-solid fa-share"></i>
                    @elseif($phase['id'] === 12)
                        <i class="fa-solid fa-chevron-right"></i>
                        <i class="fa-solid fa-chevron-right"></i>
                    @elseif($phase['id'] === 13)
                        <span class='turn-dices'></span>
                    @endif
                </span>



            </section>
        @endif
    @endforeach

</header>

<main>

    <div class='main-section'>

        <section class='players'>

            <div class='waiting-lobby'>

                @foreach ($users as $user)
                    <div class='lobby-users'>
                        <span>{{$user->username}}</span>
                    </div>
                @endforeach


            </div>

            <span class="main-btn">
                <span class='texture3'></span>
                <span class='texture2'></span>
                <span class='texture'></span>

                @if (!Auth::user()->in_game)
                    <span class='btn-content' id='userReadyBtn'>
                        PRÊT
                    </span>
                @else
                    <span class='btn-content' id='startGameBtn'>
                        COMMENCER
                    </span>
                @endif

            </span>

        </section>

        <section class='game-view not-started'>
            <div class='game-board'>
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
                </div>
                <div class='game-board-info'></div>

            </div>
        </section>

    </div>


</main>


@endsection
