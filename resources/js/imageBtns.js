const imageContainer = document.querySelector('.imageContainer');

if (imageContainer) {
    const deleteImageBtn = document.querySelector('#deleteImage');
    const currentImagePath = document.querySelector('#current_image');
    const imageDisplay = document.querySelector('#imageDisplay');
    const imageDisplayContainer = imageContainer.querySelector('.imageDisplayContainer');
    const btnContainer = document.querySelector('#imgBtnContainer');

    deleteImageBtn.addEventListener('click', function(event){
        currentImagePath.value = "";
        deleteImageBtn.classList.add('hidden');

        imageDisplayContainer.innerHTML = `
            <input class="image" label="image" name="program[image_path]" type="file" accept="image/*">
        `;
    });
}
