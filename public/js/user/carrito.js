document.addEventListener("DOMContentLoaded", function() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Función para actualizar el ícono del carrito según si el producto está en el carrito
    function actualizarIconoCarrito() {
        document.querySelectorAll('.carrito').forEach(boton => {
            const producto = JSON.parse(boton.value);
            const estaEnCarrito = carrito.some(item => item.id == producto.id);

            if (estaEnCarrito) {
                boton.classList.add('text-green-500');
                boton.classList.remove('text-gray-300');
            } else {
                boton.classList.add('text-gray-300');
                boton.classList.remove('text-green-500');
            }
        });

        // Actualizar el número del carrito
        document.querySelectorAll('.carritoNum').forEach(carritoNumero => {
            const cantidadTotal = carrito.reduce((total, item) => total + item.cantidad, 0);
            carritoNumero.textContent = cantidadTotal;
        });
    }

    // Evento de agregar/quitar del carrito
    document.querySelectorAll('.carrito').forEach(boton => {
        boton.addEventListener('click', function() {
            const producto = JSON.parse(this.value);
            const index = carrito.findIndex(item => item.id == producto.id);

            if (index > -1) {
                carrito.splice(index, 1);
                localStorage.removeItem(`productoCart${producto.id}`);
            } else {
                carrito.push({
                    id: producto.id,
                    cantidad: 1
                });
                localStorage.setItem(`productoCart${producto.id}`, JSON.stringify(producto));
            }

            localStorage.setItem('carrito', JSON.stringify(carrito));
            actualizarIconoCarrito();
        });
    });

    actualizarIconoCarrito();
});
