const spanValorCarrito = document.getElementById('valorCarrito');

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

function agregarCarritoLogueado(existe){
    if(existe){
        console.log("quitar de la bbdd");
    }
    else{
        console.log("añadir a la bbdd");
        
    }
}