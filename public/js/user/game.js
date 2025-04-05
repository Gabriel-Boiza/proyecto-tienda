document.addEventListener('DOMContentLoaded', function() {
    const escenario = document.getElementById('escenario');
    let cont = 0
    let cubo = crearCubo();
    let objetivo = crearObjetivo();

    objetivo.addEventListener('dragover', function(event){
        event.preventDefault()
    })


    objetivo.addEventListener('drop', function(event){
        cont++
        document.getElementById('puntuacion').textContent = cont

        if(cont === 5){abrirDialogo()}       
         
        posicionRandom(cubo)
        posicionRandom(objetivo)

    })

    function crearCubo() {
        let cubo = document.createElement('div');
        cubo.className = "cubo";
        cubo.draggable = true;

        posicionRandom(cubo)

        escenario.appendChild(cubo);

        return cubo;
    }

    function crearObjetivo() {
        let objetivo = document.createElement('div');
        objetivo.className = "objetivo";

        posicionRandom(objetivo)

        escenario.appendChild(objetivo);

        return objetivo;
    }

    function posicionRandom(objeto){
        const maxX = escenario.offsetWidth - objeto.offsetWidth;
        const maxY = escenario.offsetHeight - objeto.offsetHeight;

        const randomX = Math.random() * maxX + 50;
        const randomY = Math.random() * maxY + 100;

        objeto.style.left = `${randomX}px`;
        objeto.style.top = `${randomY}px`;   
    }

    async function abrirDialogo() {
        const dialogo = document.getElementById('dialog');
        const descripcion = document.getElementById('dialog-descripcion');
        
        let cupon = await peticionFetch('/cupon', 'GET', null)
        console.log(cupon);
        
        descripcion.textContent = `Has ganado un ${cupon.descuento}% de descuento! Usa el cupón ${cupon.codigo}`; 
        
        dialogo.showModal(); 
    }
});
