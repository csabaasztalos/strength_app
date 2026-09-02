
const confirmModal = document.querySelector('#confirmCopy');

if (confirmModal) {
    const openBtn = document.querySelector('#copyPasteWeeks');
    const closeBtns = document.querySelectorAll('.modalClose');

    openBtn.addEventListener('click', function(event) {
        confirmModal.showModal();
    });

    closeBtns.forEach( btn => {
        btn.addEventListener('click', function(event) {
            confirmModal.close();
        });
    });
}