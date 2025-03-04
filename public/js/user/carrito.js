document.addEventListener("DOMContentLoaded", function(event) {
console.log(localStorage);
    const carritoBtn = document.getElementsByClassName('carrito');
    const carritoNum = document.querySelector('.carritoNum');
    
    // Actualizar el número de productos en el carrito
    const actualizarCarritoNum = () => {
        const carrito = Object.keys(localStorage).filter(key => key.startsWith('productoCart')).length;
        carritoNum.textContent = carrito;
    }
    actualizarCarritoNum();

    Array.from(carritoBtn).forEach(btn => {

        let producto = JSON.parse(btn.value);
        let productoIdCart =  'productoCart' + producto.id;
        if (localStorage.getItem(productoIdCart)) {
            btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
        }
        btn.addEventListener('click', function(event){
            
            if (localStorage.getItem(productoIdCart)) {
                localStorage.removeItem(productoIdCart)
                btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
            } else {
                localStorage.setItem(productoIdCart, JSON.stringify(producto));
                btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
            }
            actualizarCarritoNum();
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
        fetch('/requestLoginCliente', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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

