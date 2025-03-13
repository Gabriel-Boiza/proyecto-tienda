

document.addEventListener("DOMContentLoaded", function() {

    actualizarCarrito()

    const carritoBtn = document.getElementsByClassName('carrito');
    Array.from(carritoBtn).forEach(btn => {
        let producto = JSON.parse(btn.value);
        let productoId = 'productoCarrito' + producto.id; 

        btn.addEventListener('click', async function(event){
            resultado = await peticionFetch('/api/carrito', 'GET', null)
            console.log(resultado);
        })
        
        
    })
});

