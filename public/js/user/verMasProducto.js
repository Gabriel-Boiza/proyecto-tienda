document.addEventListener('DOMContentLoaded', function(event) {
    console.log(localStorage);
    
    let cantidad = document.getElementById('cantidadProducto')
    let agregarBtn = document.getElementById('agregar')
    let sumar = document.getElementById('sumar')
    let restar = document.getElementById('restar')

    // Evitar que se escriban letras
    cantidad.addEventListener('input', function(event) {
        // Permite solo números, sin espacios ni símbolos
        cantidad.value = cantidad.value.replace(/\D/g, '') || 1
    })

    sumar.addEventListener('click', function(event) {
        cantidad.value = parseInt(cantidad.value) + 1
    })

    restar.addEventListener('click', function(event) {
        cantidad.value = Math.max(1, parseInt(cantidad.value) - 1)
    })
    
    agregarBtn.addEventListener('click', function(event){
        let producto = JSON.parse(agregarBtn.value);
        let productoId = 'productoCarrito' + producto.id; 

        if(localStorage.getItem(productoId) == null){
            producto.cantidad = parseInt(cantidad.value)
            localStorage.setItem(productoId, JSON.stringify(producto))
        }
        else{
            productoAux = localStorage.getItem(productoId)
            productoAux = JSON.parse(productoAux);
            productoAux.cantidad += parseInt(cantidad.value);
            localStorage.setItem(productoId, JSON.stringify(productoAux))
        }
        actualizarCarrito()
    })
})
