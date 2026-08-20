//
const message = document.querySelector('#message');

if (message) {
    setTimeout(() => {
        message.classList.add('remove');
        message.addEventListener('animationend', ()=>{
            message.remove();
        })
    }, 3000);
}


