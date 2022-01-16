<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fief Online - {{ $user->username }}</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>

<body class='lobby-container'>

    <main>

        <section class='game-room'>

            <div class='game-lobby'>

                <p>Joueurs connectés</p>

                <div class='new-game-lobby' id='lobby'>
                    @foreach ($loggedPlayers as $player)
                        <span @class(['lobby-player', 'ready' => $player->is_ready])
                        id='{{$player->username}}'>
                            {{$player->username}}
                        </span>
                    @endforeach
                </div>

            </div>

            <div class='user-btns'>
                @if($user->in_game)
                    <button id='connectBtn'>Vers la partie</button>
                @else
                    <button id='readyBtn'>Prêt !</button>
                @endif
                <form method='POST' action='{{ route("logout") }}'>
                    @csrf
                    <button type='submit'>Log out</button>
                </form>
            </div>
            
        </section>

        <section class='chat'>

            <div class='messages' id='chatMessages'></div>

            <div class='write-message'>
                <textarea type='text' id='message' placeholder='Message...'></textarea>
                <button id='sendMessageBtn'>Envoyer</button>
            </div>

        </section>
    </main>
</body>

<script src="{{asset('/js/lobby.js')}}"></script>
</html>