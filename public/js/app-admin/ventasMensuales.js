document.addEventListener("DOMContentLoaded", function () {
    fetch("/pedidos-mensuales")
        .then(response => response.json())
        .then(data => {
            const contenedor = document.getElementById("graficoPedidosMensuales");

            if (data.length === 0) {
                contenedor.innerHTML = "<p class='text-gray-500'>No hay datos disponibles.</p>";
                return;
            }

            const maxTotal = Math.max(...data.map(item => item.total));

            // Crear el canvas dinámicamente
            const canvas = document.createElement("canvas");
            canvas.width = 500; // Ajusta el ancho según lo necesites
            canvas.height = data.length * 50 + 50; // Altura de las barras más espacio entre ellas
            contenedor.appendChild(canvas);

            const ctx = canvas.getContext("2d");

            // Configuración de dimensiones
            const margenIzquierdo = 10; // Espacio desde el borde
            const margenSuperior = 20;
            const anchoMaximo = canvas.width - 40; // Ajustamos para dejar espacio a la derecha
            const alturaBarra = 30;
            const espacio = 15; // Espacio entre barras

            // Limitar el ancho máximo de las barras
            const maxBarWidth = anchoMaximo * 0.8; // Limitar al 80% del ancho del canvas

            // Establecer la fuente y estilo
            const fontFamily = getComputedStyle(document.documentElement).getPropertyValue('--font-sans').trim();
            ctx.font = `14px ${fontFamily} Bold`;
            ctx.textBaseline = 'middle'; // Centrar el texto verticalmente en la barra

            // Dibujar las barras
            data.forEach((item, i) => {
                const y = margenSuperior + i * (alturaBarra + espacio);
                // Calcular el ancho, limitándolo al máximo permitido
                const ancho = Math.min((item.total / maxTotal) * anchoMaximo, maxBarWidth);

                // Dibuja la barra
                ctx.fillStyle = "#59168b"; // Color de la barra
                ctx.fillRect(margenIzquierdo, y, ancho, alturaBarra);

                // Texto incrustado dentro de la barra (nombre + total)
                ctx.fillStyle = "#fff";
                const texto = `${item.mes_nombre} (${item.total})`;

                // Colocar el texto en la barra
                ctx.fillText(texto, margenIzquierdo + 10, y + alturaBarra / 2);
            });
        })
        .catch(error => console.error("Error al obtener datos:", error));
});