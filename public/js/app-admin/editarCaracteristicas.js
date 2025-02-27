document.addEventListener('DOMContentLoaded', function(event){
    id = obtenerId()
    peticionCaracteristicas(id)

    
    
})


async function peticionCaracteristicas(id){

    let datos = await fetch(`/api/caracteristicas/${id}`)
    console.log(datos);
    

}

function obtenerId(){
    url = window.location.href;
    valores = url.split('/')
    id = parseInt(valores[4]);
    return id
}