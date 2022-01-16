<figure class='card {{$type}}-card'])>

    @if ($type == 'lord' || 'event')

        <img src='../storage/app/public/images/f.png'>
        <span class='overline-b'></span>

    @elseif ($type == 'disaster')
    
        <img src='../storage/app/public/images/f-w.png'>
        <span class='overline-w'></span>
        
    @endif


</figure>