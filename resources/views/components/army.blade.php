<div class='army'>

    {{-- BANNER --}}
    {{-- <canvas height="400px" width="250px" class='banner'></canvas> --}}

    <div class='lord-forces'>
        @foreach($village->lords()->get() as $lord)
            <span id="{{$lord->name}}" class='lord'></span>
        @endforeach
    </div>
    

    <div class='army-forces'>
        <div class='sergeant'>
            <span class='sergeant token'></span>
            <span class='force-counter'>3</span>
        </div>
        <div class='knight'>
            <span class='knight token'></span>
            <span class='force-counter'>1</span>
        </div>
    </div>


    <div class='move-options'>
        <i id='move-option-inspect' class="fas fa-search"></i>
        <i id='move-option-let-one' class="fas fa-male"></i>
        <i id='move-option-move-all' class="fas fa-angle-double-right"></i>
        <i id='move-option-close' class="fas fa-times-circle"></i>
    </div>

</div>