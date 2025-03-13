

document.addEventListener("DOMContentLoaded", function() {

    actualizarCarrito()

    const carritoBtn = document.getElementsByClassName('carrito');
    Array.from(carritoBtn).forEach(btn => {
        let producto = JSON.parse(btn.value);
        let productoId = 'productoCarrito' + producto.id; 

        btn.innerHTML = iconoCarrito(localStorage.getItem(productoId) !== null); //si encuentra el producto envia true

        btn.addEventListener('click', function(event){
            //primero se añade o se quita del localstorage con la primera funcion, y se comprueba el estado para determinar el icono con la segunda
            localStorageCarrito(JSON.stringify(producto), productoId, localStorage.getItem(productoId) !== null);
            btn.innerHTML = iconoCarrito(localStorage.getItem(productoId) !== null); 
            actualizarCarrito()
        })

        
    })
});

