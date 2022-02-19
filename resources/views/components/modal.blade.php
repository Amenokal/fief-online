<div @class([
    'modal',
    'marriage-modal' => $phase === 2,
    'bishop-election' => $phase === 3
])>

    <div class='parchm-top'>

        @if($phase === 2)
            @include('partials.modal.phase2')
        @elseif ($phase === 3)
            @include('partials.modal.phase3')
        @endif

    </div>

    <span class='parchm-bottom'>
        @if($phase === 2)
            <button class='modal-btn'>Proposer un marriage</button>
        @elseif ($phase === 3)
            <button class='modal-btn'>Passer</button>
        @endif
    </span>

</div>
