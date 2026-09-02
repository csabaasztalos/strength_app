
const startModal = document.querySelector('#startConfirm');

if (startModal) {
    const openBtn = document.querySelector('#openStartModal');
    const closeBtns = document.querySelectorAll('.modalClose');

    openBtn.addEventListener('click', function(event) {
        startModal.showModal();
    });

    closeBtns.forEach( btn => {
        btn.addEventListener('click', function(event) {
            startModal.close();
        });
    });
}
