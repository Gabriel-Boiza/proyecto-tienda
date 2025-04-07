document.addEventListener('DOMContentLoaded', () => {
    const contenedorCarrito = document.getElementById('carritoLocalStorage2');
    const contenedorVacio = document.getElementById('carritoVacio');

    let llaves = Object.keys(localStorage).filter(key => key.startsWith('productoCarrito'))

    llaves.forEach(llave => {
        
        contenidoCarrito(contenedorCarrito, JSON.parse(localStorage.getItem(llave)), llave)
    });
});


function contenidoCarrito(contenedor, producto, productoId){
    
    let article = document.createElement('article');
    article.className = 'border-b border-gray-700 pb-4 last:border-0 last:pb-0'

    let div1 = document.createElement('div')
    div1.className = 'flex items-center gap-4'

    let divImagen = document.createElement('div')
    divImagen.className = 'w-20 h-20 bg-gray-700 rounded-lg overflow-hidden'
    let imagen = document.createElement('img')
    imagen.src = `/storage/${producto.imagen_principal}`
    imagen.alt = producto.nombre
    divImagen.appendChild(imagen)

    let div2 = document.createElement('div')
    div2.className = 'flex-grow'

    let titulo = document.createElement('h3')
    let descripcion = document.createElement('p')
    titulo.textContent = producto.nombre
    titulo.className = 'font-medium'
    descripcion.className = 'text-gray-400 text-sm'
    descripcion = producto.descripcion

    let div21 = document.createElement('div')
    div21.className = 'flex items-center justify-between mt-2'

    let div211 = document.createElement('div')
    div211.className = 'flex items-center gap-2'

    let sumarBtn = document.createElement('button')
    let restarBtn = document.createElement('button')

    restarBtn.innerHTML = `<svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>`
    sumarBtn.innerHTML = `<svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>`
    let cantidadSpan = document.createElement('span')
    cantidadSpan.classList = 'px-3 py-1 bg-gray-700 rounded-md'
    cantidadSpan.textContent = producto.cantidad

    sumarBtn.addEventListener('click', function(event){
        producto.cantidad++
        cantidadSpan.textContent = producto.cantidad
        localStorage.setItem(productoId, JSON.stringify(producto))        
    })

    restarBtn.addEventListener('click', function(event){
        if(producto.cantidad > 1){
            producto.cantidad--
            cantidadSpan.textContent = producto.cantidad
            localStorage.setItem(productoId, JSON.stringify(producto))    
        }    
    })

    div211.append(restarBtn, cantidadSpan, sumarBtn)

    let eliminarBtn = document.createElement('button');
    eliminarBtn.innerHTML = `<svg class="w-5 h-5 text-red-500 hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`;    
    eliminarBtn.addEventListener('click', function(event){
        contenedor.removeChild(article); 
        localStorage.removeItem(productoId)
        actualizarCarrito()
    })

    div21.append(div211, eliminarBtn)
    div2.append(titulo, descripcion, div21)

    div1.appendChild(divImagen)
    div1.appendChild(div2)
    article.appendChild(div1)

    contenedor.appendChild(article)
}   