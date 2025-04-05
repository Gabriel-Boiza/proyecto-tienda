document.addEventListener('DOMContentLoaded', function(event){
    let contenedorPrincipal = document.getElementById('contenedorPrincipal');
    let spanTotalElement = document.getElementById('total');

    document.addEventListener('click', async function(event){
        let target = event.target.closest('button');
        if(target){
            let cantidadElemento = target.parentElement.querySelector('.cantidadLogged');
        
            if (target.className === 'sumarCantidad') {
                let valor = parseInt(cantidadElemento.textContent)+1;
                cantidadElemento.textContent = valor;
                await peticionFetch(`/actualizarCantidad/${target.dataset.id}`, 'POST', valor);
                actualizarTotales();
            }
            else if(target.className === 'restarCantidad' && parseInt(cantidadElemento.textContent) > 1){
                let valor = parseInt(cantidadElemento.textContent)-1;
                cantidadElemento.textContent = valor;
                await peticionFetch(`/actualizarCantidad/${target.dataset.id}`, 'POST', valor);
                actualizarTotales();
            }
            else if(target.className === 'eliminar'){
                contenedorProducto = event.target.closest('.contenedorProducto');
                contenedorPrincipal.removeChild(contenedorProducto);
                await peticionFetch(`/api/carrito/${target.dataset.id}`, 'DELETE', null);
                spanValorCarrito.textContent = parseInt(spanValorCarrito.textContent)-1;
                actualizarMensajeStock();
                actualizarTotales();
            }
        }
    });

    function actualizarTotales() {
        let productosContenedores = document.querySelectorAll('.contenedorProducto');
        let totalGeneral = 0;
        
        productosContenedores.forEach(producto => {
            const precioTexto = producto.querySelector('.text-lg.font-bold').textContent.trim();
            let precioProducto = parseFloat(precioTexto.replace('€', '').replace(',', '.'));
            
            if (precioTexto.includes('€')) {
                precioProducto = parseFloat(precioTexto.split('€')[0].replace(',', '.'));
            }
            
            const cantidad = parseInt(producto.querySelector('.cantidadLogged').textContent);
            
            const totalProducto = precioProducto * cantidad;
            totalGeneral += totalProducto;
            
            const totalProductoElement = producto.querySelector('#total_producto');
            if (totalProductoElement) {
                totalProductoElement.textContent = `Total: ${totalProducto.toFixed(2).replace('.', ',')}€`;
            }
        });
        
        if (spanTotalElement) {
            spanTotalElement.textContent = `${totalGeneral.toFixed(2).replace('.', ',')}€`;
        }
    }

    async function actualizarMensajeStock(){
        let respuesta = await peticionFetch('/verificarStock', 'GET', null);
        
        if (!respuesta.respuesta && document.getElementById('noDisponibles')) {
            document.getElementById('noDisponibles').remove();
        
            let btnProceder = document.getElementById('proceder-compra');
            btnProceder.classList.remove('opacity-50', 'pointer-events-none');
            btnProceder.setAttribute('data-enabled', 'true');
        }
    }
    
    actualizarTotales();
});