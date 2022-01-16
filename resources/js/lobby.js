const { default: axios } = require('axios');

require('./bootstrap');

// CHAT //
const sendMsg = document.getElementById('sendMessageBtn');
sendMsg.addEventListener('click',(e)=>{
    axios.post('/fief/public/lobby/msg', {
        message: document.getElementById('message').value
    })
});
window.Echo.channel('lobby-chat-channel')
    .listen('.message-event', e => {
        document.getElementById('chatMessages').innerHTML += e.message;
        document.getElementById('message').value = '';
    }
);



// LOG EVENTS //
window.Echo.channel('log-channel')
.listen('.log-in-event', e => {
    document.getElementById('lobby').innerHTML += e.template
});

window.Echo.channel('log-channel')
.listen('.log-out-event', e => {
    document.getElementById(e.username).remove()
});

if(document.getElementById('connectBtn')){
    document.getElementById('connectBtn').addEventListener('click', ()=>{
        window.location.href = '/fief/public/game'
    })
}

// INIT GAME
if(document.getElementById('readyBtn')){
    document.getElementById('readyBtn').addEventListener('click', ()=>{
        axios.get('/fief/public/lobby/ready')
    });
}
window.Echo.channel('ready-channel')
.listen('.ready-event', e => {
    document.getElementById(e.username).classList.toggle('ready');
    if(document.querySelectorAll('.lobby-player').length == document.querySelectorAll('.ready').length){
        // window.location.href = '/fief/public/game'
    }
});



function countdown(){
    let count = 3;
    document.getElementById('chatMessages').innerHTML +=
    `<p class='init-game-msg'>La partie démarre dans ${count} secondes...</p>`
    let countdown = setInterval(() => {
        if(count>0 && allPlayersReady()){
            count--;
            let message;
            if(count!=0){
                message = `<p class='init-game-msg'>La partie démarre dans ${count} secondes...</p>`
            } else {
                message = `<p class='init-game-msg'>La partie va démarrer...</p>`
            }
            document.getElementById('chatMessages').innerHTML += message;
        } else if (count>0 && !allPlayersReady()){
            clearInterval(countdown);
        } else if (count==0 && allPlayersReady()){      
            clearInterval(countdown);
            axios.get('/fief/public/lobby/connect')
        } else {
            axios.get('/log/out');
        }

    }, 1000);
};
