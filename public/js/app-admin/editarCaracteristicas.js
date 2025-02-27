document.addEventListener('DOMContentLoaded', async function(event){
    id = obtenerId()
    datos = await peticionCaracteristicas(id)
    generarCaracteristicas(datos)
    funcionCrear()
    funcionAgregar(datos)
    
    
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
        console.log(await respuesta.json());  
    }
}


function generarCaracteristicas(datos) {
    const div = document.getElementById('caracteristicas-container');
    const caracteristicas = datos.caracteristicas;
    const pc = datos.productos_caracteristicas.caracteristicas;
    

    pc.forEach(caracteristica => {
        const select = document.createElement('select');
        select.name = "caracteristicas[]";
        select.classList.add('appearance-none', 'w-[95%]', 'bg-zinc-800', 'border', 'border-zinc-700', 'rounded-md', 'px-4', 'py-2', 'text-white', 'focus:border-purple-500', 'focus:ring-1', 'focus:ring-purple-500', 'mb-2');
      
        const optionDefault = document.createElement('option');
        optionDefault.value = caracteristica.id;
        optionDefault.selected = true;
        optionDefault.textContent = caracteristica.nombre;
        select.appendChild(optionDefault);

        caracteristicas.forEach(c => {
            if(c.id != caracteristica.id){
                const option = document.createElement('option')
                option.value = c.id
                option.textContent = c.nombre
                select.appendChild(option)
            }
        }); 

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

        deleteBtn.addEventListener('click', function(event){
            div.removeChild(select)
            div.removeChild(deleteBtn)
        })

        div.appendChild(select)
        div.appendChild(deleteBtn)
    });
}



async function peticionCaracteristicas(id) {
    try {
        let response = await fetch(`/api/caracteristicas/${id}`)

        if (!response.ok) {  throw new Error('Error al obtener los datos');}

        let datos = await response.json();  
        return datos;

    } catch (error) {
        console.error('Hubo un problema con la solicitud:', error); 
    }
}


function obtenerId(){
    url = window.location.href;
    valores = url.split('/')
    id = parseInt(valores[4]);
    return id
}

function funcionAgregar(datos) {
    let agregarBtn = document.getElementById("agregarCaracteristica");
    const div = document.getElementById('caracteristicas-container');
    const caracteristicas = datos.caracteristicas;

    agregarBtn.addEventListener('click', function(event) {
        
        const select = document.createElement('select');
        select.name = "caracteristicas[]";
        select.classList.add('appearance-none', 'w-[95%]', 'bg-zinc-800', 'border', 'border-zinc-700', 'rounded-md', 'px-4', 'py-2', 'text-white', 'focus:border-purple-500', 'focus:ring-1', 'focus:ring-purple-500', 'mb-2');
      
        caracteristicas.forEach(caracteristica => {
            const option = document.createElement('option')
            option.value = caracteristica.id
            option.textContent = caracteristica.nombre
            select.appendChild(option)
        })

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

        deleteBtn.addEventListener('click', function(event){
            div.removeChild(select)
            div.removeChild(deleteBtn)
        })

        div.appendChild(select)
        div.appendChild(deleteBtn)
    });
    
}