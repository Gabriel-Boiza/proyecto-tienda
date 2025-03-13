async function peticionFetch(url, metodo, body) { //funcion para generalizar consultas fetch
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); 

    const opciones = {
        method: metodo, 
        headers: {
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': token, 
        },
    };

    if (body) {
        opciones.body = JSON.stringify(body);
    }

    const response = await fetch(url, opciones);

    if (!response.ok) {throw new Error(`Error en la petición`)}

    const data = await response.json(); 
    return data; 


}
