<nav>
    {{-- <div class='move-btns'>
        <h2>ACTIONS</h2>
        <div>
            <button id='moveBtn'>Move</button>
            <button id='disasters-btn'>Calamités</button>
            <button id='income-btn'>Revenus</button>
        </div>
    </div>
    <div class='building-btns'>
        <h2>BUY</h2>
        <div>
            <button class='moulin' id='buyBtn-moulin'></button>
            <button class='token sergeant' id='buyBtn-sergeant'></button>
            <button class='crown' id='buyBtn-crown'></button>
            <button class='chateau' id='buyBtn-chateau'></button>
            <button class='token knight' id='buyBtn-knight'></button>
            <button class='cardinal' id='buyBtn-cardinal'></button>
        </div>
    </div>
    <div class='reset-btns'>
        <h2>OPTIONS</h2>
        <div>
            <button id='fullScreen'>FullScreen</button>
            <button id='resetAll'>Reset</button>
        </div>
    </div> --}}


    @if ($phase === 2)
        <button class="main-btn" id='marryMyself'>Proposer un marriage</button>
    @endif


        <button class="main-btn" id='end-turn'>Fin du tour</button>
</nav>
