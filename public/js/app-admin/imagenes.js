let currentImageIndex = 0;
const images = [];

document.addEventListener("DOMContentLoaded", () => {
    const mainImage = document.getElementById("mainImage");
    if (!mainImage) return;

    images.push(mainImage.src);

    // Obtener imágenes adicionales desde un atributo de datos del HTML
    const additionalImages = document.getElementById("mainImage").dataset.additionalImages;
    if (additionalImages) {
        images.push(...JSON.parse(additionalImages));
    }

    mainImage.style.transition = "opacity 150ms ease-in-out";
});

function navigateImages(direction) {
    if (direction === "next") {
        currentImageIndex = (currentImageIndex + 1) % images.length;
    } else {
        currentImageIndex = currentImageIndex === 0 ? images.length - 1 : currentImageIndex - 1;
    }
    updateMainImage();
}

function updateMainImage() {
    const mainImage = document.getElementById("mainImage");
    if (!mainImage) return;

    mainImage.style.opacity = "0";
    setTimeout(() => {
        mainImage.src = images[currentImageIndex];
        mainImage.style.opacity = "1";
    }, 150);
}
