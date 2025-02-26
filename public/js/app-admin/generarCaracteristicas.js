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
        console.log(await respuesta.json());  
    }
}

function funcionAgregar() {
    let agregarBtn = document.getElementById("agregarCaracteristica");
    let container = document.getElementById("caracteristicas-container");

    agregarBtn.addEventListener('click', function(event) {

        let nuevoDiv = document.createElement('div');
        nuevoDiv.classList.add('caracteristica-input');

        let nuevoInput = document.createElement('input');
        nuevoInput.type = 'text';
        nuevoInput.name = 'caracteristicas[]';
        nuevoInput.classList.add('appearance-none', 'w-full', 'bg-zinc-800', 'border', 'border-zinc-700', 'rounded-md', 'px-4', 'py-2', 'text-white', 'focus:border-purple-500', 'focus:ring-1', 'focus:ring-purple-500', 'mt-3');
        nuevoInput.placeholder = 'Añadir característica';

        nuevoDiv.appendChild(nuevoInput);

        container.appendChild(nuevoDiv);
    });
}   