class Juego {
    constructor() {
        this.escenario = document.getElementById('escenario');
        this.puntuacion = 0;
        this.cubo = null;
        this.objetivo = null;
        this.puntosNecesarios = 5;
    }

    iniciar() {
        this.cubo = new ElementoArrastrable(this.escenario);
        this.objetivo = new ZonaObjetivo(this.escenario, this);
        
        document.getElementById('puntuacion').textContent = this.puntuacion;
    }

    incrementarPuntuacion() {
        this.puntuacion++;
        document.getElementById('puntuacion').textContent = this.puntuacion;
        
        if (this.puntuacion === this.puntosNecesarios) {
            this.finalizarJuego();
        }
        
        this.cubo.posicionarAleatoriamente();
        this.objetivo.posicionarAleatoriamente();
    }

    async finalizarJuego() {
        const dialogo = document.getElementById('dialog');
        const descripcion = document.getElementById('dialog-descripcion');
        
        let cupon = await this.peticionFetch('/cupon', 'GET', null);
        console.log(cupon);
        
        descripcion.textContent = `Has ganado un ${cupon.descuento}% de descuento! Usa el cupón ${cupon.codigo}`;
        
        dialogo.showModal();
    }

    async peticionFetch(url, metodo, datos) {
        try {
            const opciones = {
                method: metodo,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            
            if (datos) {
                opciones.body = JSON.stringify(datos);
            }
            
            const respuesta = await fetch(url, opciones);
            return await respuesta.json();
        } catch (error) {
            console.error('Error en la petición:', error);
            return null;
        }
    }
}

class ElementoEscenario {
    constructor(escenario) {
        this.escenario = escenario;
        this.elemento = null;
    }

    posicionarAleatoriamente() {
        const maxX = this.escenario.offsetWidth - this.elemento.offsetWidth;
        const maxY = this.escenario.offsetHeight - this.elemento.offsetHeight;

        const randomX = Math.random() * maxX + 50;
        const randomY = Math.random() * maxY + 100;

        this.elemento.style.left = `${randomX}px`;
        this.elemento.style.top = `${randomY}px`;
    }
}

class ElementoArrastrable extends ElementoEscenario {
    constructor(escenario) {
        super(escenario);
        this.crear();
    }

    crear() {
        this.elemento = document.createElement('div');
        this.elemento.className = "cubo";
        this.elemento.draggable = true;

        this.posicionarAleatoriamente();
        this.escenario.appendChild(this.elemento);
    }
}

class ZonaObjetivo extends ElementoEscenario {
    constructor(escenario, juego) {
        super(escenario);
        this.juego = juego;
        this.crear();
        this.configurarEventos();
    }

    crear() {
        this.elemento = document.createElement('div');
        this.elemento.className = "objetivo";

        this.posicionarAleatoriamente();
        this.escenario.appendChild(this.elemento);
    }

    configurarEventos() {
        this.elemento.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

        this.elemento.addEventListener('drop', (event) => {
            this.juego.incrementarPuntuacion();
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const juego = new Juego();
    juego.iniciar();
});