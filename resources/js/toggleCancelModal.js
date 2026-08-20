
const modal = document.querySelector('#cancelConfirm');
const openBtns = document.querySelectorAll('.openModal');
const closeBtns = document.querySelectorAll('.modalClose');

openBtns.forEach( btn => {
    btn.addEventListener('click', function(event) {
        modal.showModal();
    });
});

closeBtns.forEach( btn => {
    btn.addEventListener('click', function(event) {
         modal.close();
    });
});

