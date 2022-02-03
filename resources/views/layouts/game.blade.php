<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fief Online - {{ Auth::user()->username }}</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class='game-container'>

        <x-game-content
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

    </div>

</body>

<script src="{{asset('/js/game.js')}}"></script>

</html>
