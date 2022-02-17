@extends('../layouts/game')

@section('content')

    <x-game-content
    :game="$game"
    :users="$users"

    :phases="$phases"
    :turn="$turn"
    :currentplayer="$current_player"
    :families="$families"

    :villages="$villages"
    :army="$army"
    :player="$player"
    :lords="$lords"
    :buildings="$buildings"

    :nextlord="$next_lord_card"
    :nextevent="$next_event_card"
    :disasters="$inc_disasters"
    :lorddiscard="$lord_discard_pile"
    :eventdiscard="$event_discard_pile"
    :remnlords="$remaining_lords"
    :remnbuildings="$remaining_buildings"

    :playercards="$player_cards"
    />

@endsection
