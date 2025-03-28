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

        if(cont === 2){
            
        }        
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

        const randomX = Math.random() * maxX;
        const randomY = Math.random() * maxY;

        objeto.style.left = `${randomX}px`;
        objeto.style.top = `${randomY}px`;   
    }
});
