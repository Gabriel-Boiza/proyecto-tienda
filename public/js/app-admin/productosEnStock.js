document.addEventListener('DOMContentLoaded', function () {
    // Realizar una solicitud fetch para obtener los productos desde el backend
    fetch("/productos-stock")
        .then(response => response.json())
        .then(productos => {
            // Si no hay productos, mostrar un mensaje
            if (!productos || productos.length === 0) {
                document.getElementById('graficoStock').innerHTML = "<p class='text-gray-500'>No hay datos disponibles.</p>";
                return;
            }

            const datos = [];
            const etiquetas = [];

            productos.forEach(producto => {
                if (producto.stock != null) {
                    datos.push(producto.stock);
                    etiquetas.push(producto.nombre);
                }
            });

            // Crear el canvas
            const canvas = document.createElement("canvas");
            canvas.width = 500; // Ancho del gráfico
            canvas.height = productos.length * 50 + 50; // Ajusta la altura según la cantidad de productos
            document.getElementById("graficoStock").appendChild(canvas);

            const ctx = canvas.getContext("2d");

            // Configuración de dimensiones
            const margenIzquierdo = 10;
            const margenSuperior = 20;
            const anchoMaximo = canvas.width - 200;
            const alturaBarra = 30;
            const espacio = 15; // Espacio entre barras
            const maxValor = Math.max(...datos);

            // Limitar el ancho de las barras
            const maxBarWidth = anchoMaximo * 0.8;

            // Fuente
            const fontFamily = getComputedStyle(document.documentElement).getPropertyValue('--font-sans').trim();

            // Función para dibujar el gráfico
            function dibujarGrafico() {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpiar canvas

                datos.forEach((valor, i) => {
                    const y = margenSuperior + i * (alturaBarra + espacio);
                    const ancho = Math.min((valor / maxValor) * anchoMaximo, maxBarWidth);

                    // Dibuja la barra
                    ctx.fillStyle = "#59168b"; // Color de la barra
                    ctx.fillRect(margenIzquierdo, y, ancho, alturaBarra);

                    // Establecer la fuente
                    ctx.fillStyle = "#fff"; // Color del texto dentro de la barra
                    ctx.font = `14px ${fontFamily} Bold`;
                    const texto = `${etiquetas[i]} (${valor})`;
                    ctx.fillText(texto, margenIzquierdo + 10, y + alturaBarra / 1.5);
                    
                });
            }

            dibujarGrafico();
        })
        .catch(error => console.error("Error al obtener los datos:", error));
});