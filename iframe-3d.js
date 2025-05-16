let currentIndex = 0;

// Función para mover las imágenes de la galería
function moveSlide(step) {
    const images = document.querySelectorAll('.gallery-item');
    const totalImages = images.length;

    // Ocultar la imagen actual
    images[currentIndex].style.display = "none";

    // Calcular el siguiente índice
    currentIndex = (currentIndex + step + totalImages) % totalImages;

    // Mostrar la nueva imagen
    images[currentIndex].style.display = "block";
}

// Mostrar la primera imagen al cargar
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.gallery-item');
    images.forEach(image => image.style.display = "none");
    moveSlide(0);
});

document.addEventListener("DOMContentLoaded", function() {
    const toggle3DButton = document.querySelector(".three-d-section");
    const iframeContainer = document.getElementById("iframeContainer");

    toggle3DButton.addEventListener("click", function() {
        if (iframeContainer.style.display === "none" || iframeContainer.style.display === "") {
            iframeContainer.style.display = "block";
        } else {
            iframeContainer.style.display = "none";
        }
    });
});





