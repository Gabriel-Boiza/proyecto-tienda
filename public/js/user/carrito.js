document.addEventListener("DOMContentLoaded", function() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Función para actualizar el ícono de cada producto dependiendo si está en el carrito
    function actualizarIconoCarrito() {
        const carritoIconos = document.querySelectorAll('.carrito-icono');

        carritoIconos.forEach(icono => {
            const productoId = icono.closest('.producto').dataset.productoId;
            
            // Si el producto está en el carrito, cambiar el color del ícono
            if (carrito.some(producto => producto.id == productoId)) {
                icono.classList.add('text-green-500');  // Color verde si está en el carrito
                icono.classList.remove('text-gray-300'); // Remover el color gris
            } else {
                icono.classList.add('text-gray-300');  // Color gris si no está en el carrito
                icono.classList.remove('text-green-500'); // Remover el color verde
            }
        });
    }

    // Llamar a la función para actualizar los íconos al cargar la página
    actualizarIconoCarrito();

    // Añadir o quitar productos del carrito al hacer click en el ícono
    document.querySelectorAll('.carrito-icono').forEach(icono => {
        icono.addEventListener('click', function() {
            const productoId = this.closest('.producto').dataset.productoId;
            const productoIndex = carrito.findIndex(producto => producto.id == productoId);

            if (productoIndex > -1) {
                // El producto ya está en el carrito, quitarlo
                carrito.splice(productoIndex, 1);
            } else {
                // El producto no está en el carrito, añadirlo
                const producto = {
                    id: productoId,
                    nombre: this.closest('.producto').querySelector('.producto-info').textContent,
                    cantidad: 1
                };
                carrito.push(producto);
            }

            // Guardar el carrito en el localStorage
            localStorage.setItem('carrito', JSON.stringify(carrito));

            // Actualizar los íconos después de modificar el carrito
            actualizarIconoCarrito();
        });
    });
});



document.getElementById('loginForm').addEventListener('click', function(event){
    event.preventDefault(); // Evita que el formulario se envíe de forma tradicional
    let cartItems = Object.keys(localStorage)
        .filter(key => key.startsWith('productoCart'))  // Filtra solo las claves del carrito
        .map(key => JSON.parse(localStorage.getItem(key))); // Convierte cada valor JSON en objeto

    // Si hay productos en el carrito, enviarlos al backend
    if (cartItems.length > 0) {

        // Formatear los datos para que el backend los entienda
        let cartData = cartItems.map(item => ({
            producto_id: item.id, // Extrae el ID del producto
            cantidad: item.cantidad || 1 // Usa la cantidad si está guardada, de lo contrario, 1
        }));

        // Hacer una solicitud al backend para sincronizar el carrito
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/api/carrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                cart: cartData,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Carrito sincronizado:', data);
            Object.keys(localStorage).forEach(key => {
                if (key.startsWith('productoCart')) {
                    localStorage.removeItem(key);
                }
            });
            document.getElementById('loginForm').submit();
        })
        .catch(error => console.error('Error sincronizando el carrito:', error));
    } else {
        document.getElementById('loginForm').submit();
    }
});

