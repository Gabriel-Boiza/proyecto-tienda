document.addEventListener("DOMContentLoaded", function(event) {
    const favsBtn = document.getElementsByClassName('favoritos');
    
    Array.from(favsBtn).forEach(btn => {
        let producto = JSON.parse(btn.value);

        btn.addEventListener('click', function(event) {
            // Verificamos si el producto ya existe en localStorage
            let productoEnLocalStorage = localStorage.getItem('productoFavs' + producto.id);

            // Si el producto existe, eliminamos el hijo (svg) del botón
            if (productoEnLocalStorage) {
                console.log('Producto encontrado en localStorage, eliminando el SVG...');

                // Eliminamos el primer hijo del botón, que es el SVG
                btn.innerHTML = ''; // Esto eliminará el contenido (el SVG) del botón
            } else {
                console.log('Producto no encontrado en localStorage, agregando...');
                // Si no está, lo agregamos al localStorage
                localStorage.setItem('productoFavs' + producto.id, JSON.stringify(producto));
            }
        });
    });
});
