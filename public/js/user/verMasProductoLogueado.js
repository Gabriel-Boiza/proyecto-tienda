document.addEventListener('DOMContentLoaded', function(event) {
    let cantidad = document.getElementById('cantidadProducto')
    let agregarBtn = document.getElementById('agregar')
    let sumar = document.getElementById('sumar')
    let restar = document.getElementById('restar')


    cantidad.addEventListener('input', function(event) {
        cantidad.value = cantidad.value.replace(/\D/g, '') || 1
    })

    sumar.addEventListener('click', function(event) {
        cantidad.value = parseInt(cantidad.value) + 1
    })

    restar.addEventListener('click', function(event) {
        cantidad.value = Math.max(1, parseInt(cantidad.value) - 1)
    })
    
    agregarBtn.addEventListener('click', async function(event){
        let producto = {
            idProducto: agregarBtn.value,
            valor: parseInt(cantidad.value)
        }
        datos = await peticionFetch('/agregarCarrito', 'POST', producto)
        console.log(datos);
        
        let valorCarritoNum = await peticionFetch('/cantidadCarrito', 'GET', null);
        spanValorCarrito.textContent = valorCarritoNum.cantidad
        
    })
})
