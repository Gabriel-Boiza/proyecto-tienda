document.addEventListener("DOMContentLoaded", function(event) {

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
// Filtrar los productos en el localStorage que empiezan con 'productoIdCart'
let cart = [];
for (let i = 0; i < localStorage.length; i++) {
    let key = localStorage.key(i);
    if (key.startsWith('productoIdCart')) {
        let producto = JSON.parse(localStorage.getItem(key));
        cart.push(producto);
    }
}

// Si hay productos en el carrito, enviarlos al backend
if (cart.length > 0) {
    // Obtener el ID del cliente desde la sesión
    const clienteId = "{{ Session::get('cliente_id') }}";  // Acceder al cliente desde la sesión

    // Hacer una solicitud al backend para sincronizar el carrito
    fetch('/sync-cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            cliente_id: clienteId,
            cart: cart
        }),
    })
    .then(response => response.json())
    .then(data => {
        // El carrito se ha sincronizado correctamente, puedes borrar el localStorage
        localStorage.clear();  // O puedes eliminar solo las claves del carrito: localStorage.removeItem('productoIdCart');
    })
    .catch(error => console.error('Error sincronizando el carrito:', error));
}

