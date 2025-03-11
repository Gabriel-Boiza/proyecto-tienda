document.addEventListener("DOMContentLoaded", function() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Función para actualizar el ícono del carrito según si el producto está en el carrito
    function actualizarIconoCarrito() {
        document.querySelectorAll('.carrito').forEach(boton => {
            const producto = JSON.parse(boton.value);
            // Comprobar si el producto está en el carrito (en localStorage)
            const estaEnCarrito = carrito.some(item => item.id == producto.id);

            if (estaEnCarrito) {
                boton.classList.add('text-green-500'); // Verde si está en el carrito
                boton.classList.remove('text-gray-300');
            } else {
                boton.classList.add('text-gray-300'); // Gris si no está en el carrito
                boton.classList.remove('text-green-500');
            }
        });

        // Actualizar el número del carrito
        document.querySelectorAll('.carritoNum').forEach(carritoNumero => {
            const cantidadTotal = carrito.reduce((total, item) => total + item.cantidad, 0);
            carritoNumero.textContent = cantidadTotal; // Actualizar el número
        });
    }

    // Evento de agregar/quitar del carrito
        document.querySelectorAll('.carrito').forEach(boton => {
            boton.addEventListener('click', function() {
                const producto = JSON.parse(this.value);
                const index = carrito.findIndex(item => item.id == producto.id);
        
                if (index > -1) {
                    carrito.splice(index, 1);  // Eliminar producto del carrito
                    localStorage.removeItem(`productoCart${producto.id}`);  // Eliminarlo también de localStorage
                } else {
                    carrito.push({
                        id: producto.id,
                        cantidad: 1
                    });
                    localStorage.setItem(`productoCart${producto.id}`, JSON.stringify(producto));  // Guardar en localStorage
                }
        
                // Actualizar carrito en localStorage
                localStorage.setItem('carrito', JSON.stringify(carrito));
        
                actualizarIconoCarrito();
        
                // Si el usuario está autenticado, sincronizar con la base de datos
                sincronizarCarritoBD();
            });
        });
    

    actualizarIconoCarrito();
});

// Función para sincronizar el carrito con la base de datos
function sincronizarCarritoBD() {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenElement) {
        console.error('CSRF token meta tag not found');
        return; // Salir si no se encuentra el token CSRF
    }

    const csrfToken = csrfTokenElement.content;
    console.log('CSRF Token:', csrfToken); // Verifica que el token se haya obtenido correctamente

    const usuarioAutenticado = document.querySelector('meta[name="user-authenticated"]').content === 'true';
    console.log('Usuario autenticado:', usuarioAutenticado); // Verifica que el estado de autenticación es correcto

    if (!usuarioAutenticado) return; // Si no está autenticado, no guardar en la BD

    const carrito = [];
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('productoCart')) {
            const producto = JSON.parse(localStorage.getItem(key));
            carrito.push({
                id: producto.id,  // Asegúrate de que cada producto tenga un ID
                cantidad: 1       // O cualquier otra lógica que determines para la cantidad
            });
        }
    }

    if (carrito.length === 0) {
        console.log('El carrito está vacío, no se sincroniza.');
        return;
    }

    console.log('Carrito:', carrito); // Verifica que el carrito se haya cargado correctamente

    // Realizar la solicitud AJAX para sincronizar el carrito con la BD
    fetch('/api/carrito', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ cart: carrito })
    })
    .then(response => {
        console.log('Respuesta del servidor:', response);  // Verifica lo que devuelve el servidor
        return response.json();  // Intentar convertir la respuesta en JSON si es válida
    })
    .then(data => console.log('Carrito guardado en BD:', data))
    .catch(error => console.error('Error guardando en BD:', error));
}
