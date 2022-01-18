<div class='locations'>        
    @foreach($villages as $vil)


        <span id='{{$vil->name}}' @class([
            'village' => !$vil->capital,
            'city' => $vil->capital,
        ])>
        
        {{-- <x-army/> --}}
        
        @foreach($army as $soldier)
        
        {{-- <soldiers> --}}
            {{-- @if($soldier->village_id === $vil->id)
                <span @class([
                    "token",
                    "$player->color-bordered",
                    "$soldier->type"
                ])></span>
            @endif --}}

        @endforeach

        </span>

    @endforeach

</div>