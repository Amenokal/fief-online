export function showBanner(message){
    document.querySelector('.game-view').innerHTML +=
        `<span class='banner show-banner'><p>${message}</p></span>`

    setTimeout(() => {
        document.querySelector('.banner').remove();
    }, 4000);
}
