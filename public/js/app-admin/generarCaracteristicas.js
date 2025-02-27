document.addEventListener('DOMContentLoaded', function(event){
    funcionCrear();
    funcionAgregar();
})

function funcionCrear(){
    crearBtn = document.getElementById('crearCaracteristica');

    crearBtn.addEventListener('click', function(event){
        nuevaCaracteristica = prompt('Escribe la nueva caracteristica')
        consultaCrear(nuevaCaracteristica)
    })
}

async function consultaCrear(nuevaCaracteristica) {
    let respuesta = await fetch('/caracteristicas', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({caracteristica: nuevaCaracteristica}),  
    });
    
    if(respuesta.ok){
        actualizarSelects(await respuesta.json())
    }
}

function actualizarSelects(response){

    let selects = document.querySelectorAll('select[name="caracteristicas[]"]');

    Array.from(selects).forEach(select => {
        const option = document.createElement('option')
        option.value = response.id
        option.textContent = response.nombre
        
        select.appendChild(option)
        
    });
    
}


function funcionAgregar() {
    let agregarBtn = document.getElementById("agregarCaracteristica");
    let container = document.getElementById("caracteristicas-container");

    function crearSelect() {
        // Clonar el select inicial para obtener todas sus opciones generadas por Blade
        let selectOriginal = document.querySelector('select[name="caracteristicas[]"]');
        let selectElement = selectOriginal.cloneNode(true);
        
        // Resetear la selección
        selectElement.selectedIndex = 0;
        
        // Mantener las clases de estilo
        selectElement.classList.add('appearance-none', 'flex-grow', 'bg-zinc-800', 'border', 'border-zinc-700', 'rounded-md', 'px-4', 'py-2', 'text-white', 'focus:border-purple-500', 'focus:ring-1', 'focus:ring-purple-500', 'mt-3');
        
        return selectElement;
    }
    



    agregarBtn.addEventListener('click', function(event) {

        let nuevoDiv = document.createElement('div');
        nuevoDiv.classList.add('caracteristica-input', 'flex', 'items-center', 'gap-2');
        
        // Crear el select con opciones clonando el original
        let nuevoSelect = crearSelect();
        
        // Crear el botón para eliminar con SVG de papelera
        let deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.classList.add('text-red-500', 'hover:text-red-700', 'mt-3', 'p-2');
        deleteBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18"></path>
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        `;
        
        // Agregar funcionalidad para eliminar el elemento
        deleteBtn.addEventListener('click', function() {
            container.removeChild(nuevoDiv);
        });
        
        nuevoDiv.appendChild(nuevoSelect);
        nuevoDiv.appendChild(deleteBtn);
        
        container.appendChild(nuevoDiv);
    });
    
}