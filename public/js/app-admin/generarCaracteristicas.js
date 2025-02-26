document.addEventListener('DOMContentLoaded', function(event){
    funcionCrear();
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
        console.log(await respuesta.json());  // Mostrar el mensaje de éxito
    }
}
