document.addEventListener("DOMContentLoaded", function(event) {
    const input = document.getElementById('busqueda');

    input.addEventListener('input', async function(event){
        
        busqueda(input.value)
        
    })
    
});

async function busqueda(input) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const response = await fetch('/api/productosBusqueda', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ valorBusqueda: input }) 
    });

    if (!response.ok) {throw new Error('Error al obtener los productos')}

    const productos = await response.json();

    let contenedor = document.getElementById('productos-buscados');
    contenedor.innerHTML = "";
    document.getElementById("subtitulo").innerHTML = "Productos buscados"
    productos.forEach(producto => {
        generarProductos(producto, contenedor)
    });
    

}

async function generarProductos(producto, contenedor) {

    carrito = await retornarCarrito()
   
    // Calcular el precio con descuento
    let productoId = 'productoFavs' + producto.id; 
    const precioConDescuento = (producto.precio * (100 - producto.descuento) / 100).toFixed(2);
    
    // Crear el elemento principal del producto
    const divProducto = document.createElement('div');
    divProducto.className = 'bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:-translate-y-2 transition-transform duration-300';
    
    // Crear el contenedor de la imagen y elementos superpuestos
    const divRelative = document.createElement('div');
    divRelative.className = 'relative';
    
    // Crear la imagen
    const imgProducto = document.createElement('img');
    imgProducto.src = 'storage/' + producto.imagen_principal;
    imgProducto.alt = producto.nombre;
    imgProducto.className = 'w-full h-48 object-cover';
    divRelative.appendChild(imgProducto);
    
    // Agregar etiqueta de descuento si existe
    if (producto.descuento !== 0) {
        const divDescuento = document.createElement('div');
        divDescuento.className = 'absolute top-2 left-2 bg-purple-600 px-2 py-1 rounded text-sm';
        divDescuento.textContent = `-${producto.descuento}%`;
        divRelative.appendChild(divDescuento);
    }
    
    // Crear botones de favoritos y carrito
    const divBotones = document.createElement('div');
    divBotones.className = 'absolute top-2 right-2 flex gap-2';
    
    // Botón de favoritos
    const btnFavoritos = document.createElement('button');
    btnFavoritos.className = 'favoritos p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors';
    btnFavoritos.value = JSON.stringify(producto);

    
    if(localStorage.getItem(productoId)){
        btnFavoritos.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
    }
    else{
        btnFavoritos.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
    }
    divBotones.appendChild(btnFavoritos);
    btnFavoritos.addEventListener('click', function(event){

        if (localStorage.getItem(productoId)) {
            localStorage.removeItem(productoId)
            btnFavoritos.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
        } else {
            localStorage.setItem(productoId, JSON.stringify(producto));
            btnFavoritos.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
        }
        
    })

    
    // Botón de carrito
    const btnCarrito = document.createElement('button');

    if(localStorage.getItem('flagLogged') === 'true'){  //localstorage guarda los booleanos como strings

        actualizarCarritoLogged(carrito, producto, btnCarrito)   
        btnCarrito.addEventListener('click', function(event){
            clickBtn(producto, btnCarrito)
        })
    }
    else{
        existe = localStorage.getItem('productoCarrito'+producto.id) !== null
        btnCarrito.innerHTML = iconoCarrito(existe)

        btnCarrito.addEventListener('click', function(event){
            iconoCarrito(existe)
            localStorageCarrito(producto, 'productoCarrito' + producto.id, existe)

            actualizarCarrito(producto, 'productoCarrito' + producto.id, existe)
        })
    }
    
    btnCarrito.className = 'carrito p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors';
    btnCarrito.value = JSON.stringify(producto);
    divBotones.appendChild(btnCarrito);
  
    divRelative.appendChild(divBotones);
    divProducto.appendChild(divRelative);
    
    // Crear contenido del producto
    const divContenido = document.createElement('div');
    divContenido.className = 'p-4';
    
    // Título del producto
    const h3Titulo = document.createElement('h3');
    h3Titulo.className = 'font-bold text-lg mb-2';
    h3Titulo.textContent = producto.nombre;
    divContenido.appendChild(h3Titulo);
    
    // Descripción del producto
    const pDescripcion = document.createElement('p');
    pDescripcion.className = 'text-gray-400 text-sm mb-3';
    pDescripcion.textContent = producto.descripcion;
    divContenido.appendChild(pDescripcion);
    
    // Estrellas y reseñas
    const divEstrellas = document.createElement('div');
    divEstrellas.className = 'flex items-center mb-3';
    
    const divIconosEstrellas = document.createElement('div');
    divIconosEstrellas.className = 'flex text-yellow-400 mr-2';
    
    // Crear 5 estrellas
    for (let i = 0; i < 5; i++) {
        const svgEstrella = document.createElement('div');
        svgEstrella.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
        divIconosEstrellas.appendChild(svgEstrella.firstChild);
    }
    
    divEstrellas.appendChild(divIconosEstrellas);
    
    // Texto de reseñas
    const spanReviews = document.createElement('span');
    spanReviews.className = 'text-sm text-gray-400';
    spanReviews.textContent = '(150 reviews)';
    divEstrellas.appendChild(spanReviews);
    
    divContenido.appendChild(divEstrellas);
    
    // Sección de precio y botón
    const divPrecios = document.createElement('div');
    divPrecios.className = 'flex items-center justify-between';
    
    // Contenedor de precios
    const divPrecio = document.createElement('div');
    
    // Precio con descuento
    const spanPrecio = document.createElement('span');
    spanPrecio.className = 'text-2xl font-bold';
    spanPrecio.textContent = `${precioConDescuento}€`;
    divPrecio.appendChild(spanPrecio);
    
    // Precio original si hay descuento
    if (producto.descuento !== 0) {
        const spanPrecioOriginal = document.createElement('span');
        spanPrecioOriginal.className = 'text-sm text-gray-400 line-through ml-2';
        spanPrecioOriginal.textContent = `${producto.precio}€`;
        divPrecio.appendChild(spanPrecioOriginal);
    }
    
    divPrecios.appendChild(divPrecio);
    
    // Botón "Ver más"
    const aVerMas = document.createElement('a');
    aVerMas.href = `periferico/${producto.id}`;
    aVerMas.className = 'bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition-colors';
    aVerMas.textContent = 'Ver más';
    divPrecios.appendChild(aVerMas);
    
    divContenido.appendChild(divPrecios);
    divProducto.appendChild(divContenido);
    
    contenedor.appendChild(divProducto);
}