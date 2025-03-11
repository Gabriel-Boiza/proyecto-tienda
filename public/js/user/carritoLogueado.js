document.addEventListener("DOMContentLoaded", function() {
    console.log(localStorage)

    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : ''; 

    const usuarioAutenticado = document.querySelector('meta[name="user-authenticated"]').content === 'true';

    if (!usuarioAutenticado) return;  

    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    sincronizarCarritoBD();

    function sincronizarCarritoBD() {
        if (carrito.length === 0) {
            console.log('El carrito está vacío, no se sincroniza.');
            return;
        }

        fetch('/api/carrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ cart: carrito })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Carrito sincronizado con la base de datos:', data);
            localStorage.removeItem('carrito');
        })
        .catch(error => console.error('Error sincronizando el carrito:', error));
    }

    function actualizarIconoCarrito() {
        fetch('/api/carrito')
            .then(response => response.json())
            .then(data => {
                const carritoDB = data.carrito;

                if (Array.isArray(carritoDB)) {
                    document.querySelectorAll('.carrito').forEach(boton => {
                        const producto = JSON.parse(boton.value);
                        const estaEnCarrito = carritoDB.some(item => item.id == producto.id);

                        if (estaEnCarrito) {
                            boton.classList.add('text-green-500');
                            boton.classList.remove('text-gray-300');
                        } else {
                            boton.classList.add('text-gray-300');
                            boton.classList.remove('text-green-500');
                        }
                    });

                    document.querySelectorAll('.carritoNum').forEach(carritoNumero => {
                        const cantidadTotal = carritoDB.reduce((total, item) => total + item.cantidad, 0);
                        carritoNumero.textContent = cantidadTotal;
                    });
                } else {
                    console.error('La propiedad "carrito" no es un array:', carritoDB);
                }
            })
            .catch(error => console.error('Error obteniendo carrito de la base de datos:', error));
    }

    document.querySelectorAll('.carrito').forEach(boton => {
        boton.addEventListener('click', function() {
            const producto = JSON.parse(this.value);
            const cliente = document.querySelector('meta[name="cliente-id"]').content;
            fetch('/api/carrito')
                .then(response => response.json())
                .then(data => {
                    const carritoDB = data.carrito;
                    const estaEnCarrito = carritoDB.some(item => item.id == producto.id);

                    if (estaEnCarrito) {
                        fetch(`/api/carrito/${cliente}/${producto.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Producto eliminado de la base de datos:', data);
                            carrito = carrito.filter(item => item.id !== producto.id);
                            localStorage.setItem('carrito', JSON.stringify(carrito));
                            actualizarIconoCarrito();
                        })
                        .catch(error => console.error('Error eliminando producto del carrito:', error));
                    } else {
                        carrito.push({ id: producto.id, cantidad: 1 });
                        fetch('/api/carrito', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ cart: carrito })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Producto agregado al carrito:', data);
                            localStorage.setItem('carrito', JSON.stringify(carrito));
                            actualizarIconoCarrito();
                        })
                        .catch(error => console.error('Error agregando producto al carrito:', error));
                    }
                })
                .catch(error => console.error('Error verificando carrito en la base de datos:', error));
        });
    });

    actualizarIconoCarrito();
});
