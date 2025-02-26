document.addEventListener("DOMContentLoaded", function () {

    // Función para agregar al carrito
    function addToCart(productId, quantity = 1) {
        if (isLoggedIn) {
            // Si está logueado, enviamos al backend para agregarlo al carrito de la base de datos
            fetch('/addCart', {
                method: 'POST',
                body: JSON.stringify({ producto_id: productId, cantidad: quantity }),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => alert(data.status));
        } else {
            // Si no está logueado, agregamos al localStorage
            let localCart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existingProduct = localCart.find(item => item.producto_id === productId);

            if (existingProduct) {
                existingProduct.cantidad += quantity;
            } else {
                localCart.push({ producto_id: productId, cantidad: quantity });
            }

            localStorage.setItem('cart', JSON.stringify(localCart));
            alert('Producto añadido al carrito local');
        }
    }

    // Cuando el usuario inicie sesión, sincronizamos el carrito
    function syncCart() {
        fetch('/cartDatabase')
            .then(response => response.json())
            .then(data => alert('Carrito sincronizado con éxito'));
    }

    // Aquí puedes agregar los eventos para los botones de "Añadir al carrito"
    // Supongamos que los botones tienen un atributo `data-product-id` con el ID del producto
    document.querySelectorAll('.add-to-cart-button').forEach(button => {
        button.addEventListener('click', function () {
            const productId = button.getAttribute('data-product-id');
            const quantity = 1; // O puedes obtenerlo dinámicamente de un input
            addToCart(productId, quantity);
        });
    });

    // Función para obtener el carrito del localStorage
    function getCarrito() {
        return JSON.parse(localStorage.getItem('carrito')) || [];
    }

    // Función para guardar el carrito en el localStorage
    function saveCarrito(carrito) {
        localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    // Cargar el carrito desde el localStorage
    let carrito = getCarrito();

    // Función para renderizar el carrito
    function renderCarrito() {
        const carritoContainer = document.querySelector('.grid');
        const totalElement = document.querySelector('.flex .text-2xl');
        let total = 0;

        // Limpiar la vista del carrito antes de renderizar
        carritoContainer.innerHTML = '';

        // Si el carrito está vacío, mostrar el mensaje
        if (carrito.length === 0) {
            totalElement.textContent = '$0.00';
            document.querySelector('.hidden').classList.remove('hidden');
            return;
        }

        // Si el carrito no está vacío, ocultar el mensaje de vacío
        document.querySelector('.hidden').classList.add('hidden');

        // Renderizar cada producto del carrito
        carrito.forEach(item => {
            // Calcular el precio total del producto
            let itemTotal = item.precio * item.cantidad;
            total += itemTotal;

            // Crear el HTML para cada producto
            const productoHTML = `
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img src="${item.imagen}" alt="${item.nombre}" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">${item.nombre}</h3>
                    <p class="text-gray-600">${item.descripcion}</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-lg font-semibold text-gray-900">$${item.precio.toFixed(2)}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500">Cantidad: </span>
                            <input type="number" min="1" value="${item.cantidad}" class="w-12 p-1 border rounded-md text-center" data-id="${item.id}">
                        </div>
                    </div>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 mt-4 rounded-lg w-full" data-id="${item.id}">Eliminar</button>
                </div>
            `;

            // Agregar el HTML del producto al contenedor
            carritoContainer.innerHTML += productoHTML;
        });

        // Mostrar el total del carrito
        totalElement.textContent = `$${total.toFixed(2)}`;
    }

    // Función para actualizar la cantidad de un producto en el carrito
    function actualizarCantidad(id, cantidad) {
        carrito = carrito.map(item => {
            if (item.id === id) {
                item.cantidad = cantidad;
            }
            return item;
        });
        saveCarrito(carrito);
        renderCarrito();
    }

    // Función para eliminar un producto del carrito
    function eliminarProducto(id) {
        carrito = carrito.filter(item => item.id !== id);
        saveCarrito(carrito);
        renderCarrito();
    }

    // Eventos para manejar las interacciones de cantidad y eliminación de productos
    document.querySelector('.grid').addEventListener('input', function (e) {
        if (e.target.type === 'number') {
            const id = e.target.getAttribute('data-id');
            const cantidad = parseInt(e.target.value);
            if (cantidad > 0) {
                actualizarCantidad(id, cantidad);
            }
        }
    });

    document.querySelector('.grid').addEventListener('click', function (e) {
        if (e.target.tagName === 'BUTTON') {
            const id = e.target.getAttribute('data-id');
            eliminarProducto(id);
        }
    });

    // Renderizar el carrito en la carga de la página
    renderCarrito();
});

