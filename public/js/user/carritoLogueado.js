

document.addEventListener("DOMContentLoaded", async function() {
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






function sincronizarCarrito(){
    console.log(localStorage);
}

function borrarCarritoLocal(){
    for (let i = 0; i < localStorage.length; i++) {
        let clave = localStorage.key(i); 
    

        if (clave.startsWith('productoCarrito')) {
            localStorage.removeItem(clave);
        }
    }
}