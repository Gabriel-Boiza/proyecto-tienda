document.addEventListener("DOMContentLoaded", function(event) {
    const input = document.getElementById('busqueda');

    input.addEventListener('input', async function(event){
        await busqueda(input.value)
        
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
    
    console.log(productos);
    

}