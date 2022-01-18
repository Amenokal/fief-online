<div class='locations'>        
    @foreach($villages as $vil)


        <span id='{{$vil->name}}' @class([
            'village' => !$vil->capital,
            'city' => $vil->capital,
        ])>
                
        @foreach($lords as $lord)
            @if($lord->village_id === $vil->id)
                <div class='army'>
                    <span class='lord'>
                        <canvas height="400px" width="250px" class='lord-banner'></canvas>
                    </span>
                </div>
            @endif
        @endforeach

        @foreach($buildings as $b)
            @if($b->village_id === $vil->id)
                <span class="{{$b->name}}"></span>
            @endif
        @endforeach

        </span>

    @endforeach

</div>