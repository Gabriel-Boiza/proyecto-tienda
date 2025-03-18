

document.addEventListener("DOMContentLoaded", async function() {
    await sincronizarCarrito()

    console.log(localStorage);

    borrarCarritoLocal()

    localStorage.setItem('flagLogged', true) //este script solo se ejecutara si el usuario esta logeado, entonces al estarlo sera true.
    console.log(localStorage.getItem('flagLogged'));
    
    
    actualizarCarrito()
    let carrito = await retornarCarrito()
    spanValorCarrito.textContent = carrito.carrito.length

    const carritoBtn = document.getElementsByClassName('carrito');
    Array.from(carritoBtn).forEach((btn) => {
        let producto = JSON.parse(btn.value);
        let productoId = 'productoCarrito' + producto.id; 

        actualizarCarritoLogged(carrito, producto, btn)
        
        btn.addEventListener('click', async function(event){
            clickBtn(producto, btn)
        })
    })
});






async function sincronizarCarrito() {
    let carrito = [];

    Object.keys(localStorage).forEach(clave => {
        if (clave.startsWith('productoCarrito')) {
            carrito.push(JSON.parse(localStorage.getItem(clave)));
        }
    });

    await peticionFetch('/sincronizarCarrito', 'POST', carrito);
}

function borrarCarritoLocal() {
    Object.keys(localStorage).forEach(clave => {
        if (clave.startsWith('productoCarrito')) {
            localStorage.removeItem(clave);
        }
    });
}