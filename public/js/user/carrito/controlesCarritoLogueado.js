document.addEventListener('DOMContentLoaded', function(event){
    let contenedorPrincipal = document.getElementById('contenedorPrincipal')


    document.addEventListener('click', async function(event){
        
        let target = event.target.closest('button');
        if(target){
            let cantidadElemento = target.parentElement.querySelector('.cantidadLogged');
        
            if (target.className === 'sumarCantidad') {
                let valor = parseInt(cantidadElemento.textContent)+1
                cantidadElemento.textContent = valor
                peticionFetch(`/actualizarCantidad/${target.dataset.id}`, 'POST', valor)       
            }
            else if(target.className === 'restarCantidad' && parseInt(cantidadElemento.textContent) > 1){
                let valor = parseInt(cantidadElemento.textContent)-1
                cantidadElemento.textContent = valor
                peticionFetch(`/actualizarCantidad/${target.dataset.id}`, 'POST', valor)      
            }
            else if(target.className === 'eliminar'){
                contenedorProducto = event.target.closest('.contenedorProducto')                   
                contenedorPrincipal.removeChild(contenedorProducto)
                await peticionFetch(`/api/carrito/${target.dataset.id}`, 'DELETE', null)
                spanValorCarrito.textContent = parseInt(spanValorCarrito.textContent)-1;
                actualizarMensajeStock()
            }
        }
    })

    async function actualizarMensajeStock(){
        let respuesta = await peticionFetch('/verificarStock', 'GET', null);
        
        if (!respuesta.respuesta && document.getElementById('noDisponibles')) {
            document.getElementById('noDisponibles').remove()
        
            let btnProceder = document.getElementById('proceder-compra')
            btnProceder.classList.remove('opacity-50', 'pointer-events-none')
            btnProceder.setAttribute('data-enabled', 'true')
        }
        

        
    }
    
    
})