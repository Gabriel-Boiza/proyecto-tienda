document.addEventListener('DOMContentLoaded', function(event){
    const productos = JSON.parse(document.getElementById('graficoContainer').getAttribute('data-productos'));
    console.log(productos);

    const datos = [];
    const etiquetas = [];

    productos.forEach((producto, i) => {
        if(producto.total_vendidos != null){
            datos.push(producto.total_vendidos);
            etiquetas.push(producto.id);
        }
    });

    const canvas = document.getElementById("graficoCanvas");
    const ctx = canvas.getContext("2d");

    // Dimensiones
    const anchoBarra = 50;
    const espacio = 20;
    const margenIzquierdo = 20;
    const alturaMaxima = Math.max(...datos);


    function dibujarGrafico() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        datos.forEach((valor, i) => {
            const x = margenIzquierdo + i * (anchoBarra + espacio);
            const altura = (valor / alturaMaxima) * (canvas.height - 40);
            const y = canvas.height - altura;

            // Dibuja la barra
            ctx.fillStyle = "#4CAF50";
            ctx.fillRect(x, y, anchoBarra, altura);

            // Etiqueta del valor
            ctx.fillStyle = "#000";
            ctx.fillText(valor, x + anchoBarra / 4, y - 5);

            // Etiqueta del día
            ctx.fillText(etiquetas[i], x + anchoBarra / 4, canvas.height - 10);
        });
    }

    dibujarGrafico();

})