const spanValorCarrito = document.getElementById('valorCarrito');

function actualizarCarritoLogged(carrito, producto, btn){
    const existeEnCarrito = carrito.carrito.some(valor => valor.id === producto.id);
    btn.innerHTML = iconoCarrito(existeEnCarrito); 
    spanValorCarrito.textContent = carrito.carrito.length;
}

async function agregarDB(producto, btn){
    btn.innerHTML = iconoCarrito(true)
    peticionFetch('/api/carrito', 'POST', producto);
}

async function deleteDB(producto, btn){
    btn.innerHTML = iconoCarrito(false)
    peticionFetch(`/api/carrito/${producto.id}`, 'DELETE', producto);
}

function actualizarCarrito(){
    let longitudCarrito = Object.keys(localStorage).filter(key => key.startsWith('productoCarrito')).length //obtiene la longitud del carrito
    spanValorCarrito.textContent = longitudCarrito;
}

function iconoCarrito(existe){
    if(!existe){ //si no existe lo quita del carrito
        return `<svg class="carrito-icono w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>`;
    }
    else{ //si existe lo añade al carrito
        return `<svg class="carrito-icono w-5 h-5" fill="white" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>`;
    }
}

function localStorageCarrito(producto, productoId, existe){
    if(existe){ //si existe lo quita del carrito
        localStorage.removeItem(productoId)
    }
    else{ //si no existe lo añade al carrito
        localStorage.setItem(productoId, producto)
    }
}


async function clickBtn(producto, btn){
    let carrito = await retornarCarrito()

    if(carrito.carrito.some(valor => valor.id === producto.id)){
        deleteDB(producto, btn)
        spanValorCarrito.textContent = parseInt(spanValorCarrito.textContent) - 1;
    }
    else{
        agregarDB(producto, btn)
        spanValorCarrito.textContent = parseInt(spanValorCarrito.textContent) + 1;
    }
}

async function retornarCarrito(){
    return await peticionFetch('/api/carrito', 'GET', null)
}
