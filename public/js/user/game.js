document.addEventListener('DOMContentLoaded', function() {
    const escenario = document.getElementById('escenario');

    crearCubo();
    crearObjetivo();

    function crearCubo(){
        let cubo = document.createElement('div');
        cubo.className = "cubo";
        cubo.draggable = true;

        const maxX = escenario.offsetWidth - cubo.offsetWidth;
        const maxY = escenario.offsetHeight - cubo.offsetHeight;

        const randomX = Math.random() * maxX;
        const randomY = Math.random() * maxY;

        cubo.style.left = `${randomX}px`;
        cubo.style.top = `${randomY}px`;

        escenario.appendChild(cubo);

    }

    function crearObjetivo(){
        let objetivo = document.createElement('div');
        objetivo.className = "objetivo";

        const maxX = escenario.offsetWidth - objetivo.offsetWidth;
        const maxY = escenario.offsetHeight - objetivo.offsetHeight;

        const randomX = Math.random() * maxX;
        const randomY = Math.random() * maxY;

        objetivo.style.left = `${randomX}px`;
        objetivo.style.top = `${randomY}px`;

        escenario.appendChild(objetivo);
    }


});
