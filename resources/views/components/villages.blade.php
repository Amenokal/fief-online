<div class='locations'>    

    @foreach($villages as $vil)

        <span id='{{$vil->name}}' class='village'>

            @foreach($buildings as $b)

                @if($b->village_id === $vil->id)

                    <span class="{{$b->name}}"></span>
                @endif
            @endforeach

            @foreach($occupied as $occ)
                @if($occ->id === $vil->id)
                    <div class='army'>
                        <div class='lord-forces'>
                            @foreach($occ->lords()->get() as $lord)
                                <span id="{{$lord->name}}" class='lord'></span>
                            @endforeach
                            {{-- banner here --}}
                        </div>
                        {{-- <canvas height="400px" width="250px" class='banner'></canvas> --}}

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
                @endif
            @endforeach
            
        </span>

    @endforeach
</div>