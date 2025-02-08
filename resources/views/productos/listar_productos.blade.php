<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-900 text-white p-8">
    <div class="flex">
        <!-- Aside -->
        <aside class="w-64 bg-zinc-950 p-4 rounded-l-lg fixed h-full left-0 top-0">
            <div class="text-purple-500 font-bold mb-8">Dashboard</div>
            <nav class="space-y-4">
                <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white">
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 text-purple-500">
                    <span>Productos</span>
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white">
                    <span>Clientes</span>
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white">
                    <span>Analíticas</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-xl font-bold">Lista de Productos</h1>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-md">
                    Añadir Producto
                </button>
            </div>

            <!-- Search bar -->
            <div class="mb-6">
                <input type="text" 
                       placeholder="Buscar productos..." 
                       class="w-full bg-zinc-800 rounded-md px-4 py-2 text-gray-300">
            </div>

            <!-- Products Table -->
            <div class="bg-zinc-800/50 rounded-lg overflow-hidden">
                <table id="tabla-productos" class="w-full">
                    <thead>
                        <tr class="text-left text-gray-400 border-b border-zinc-700">
                            <th class="p-4">ID</th>
                            <th class="p-4">Nombre</th>
                            <th class="p-4">Descripción</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los productos se llenarán aquí con JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Función para obtener productos usando fetch
        fetch('/api/productos')  // Hacer una solicitud GET a la ruta que retorna productos en JSON
            .then(response => response.json())  // Parsear la respuesta como JSON
            .then(data => {
                const tablaProductos = document.getElementById('tabla-productos').getElementsByTagName('tbody')[0];

                // Iterar sobre los productos y agregar las filas a la tabla
                data.forEach(producto => {
                    const row = tablaProductos.insertRow();  // Insertar una nueva fila en la tabla
                    row.className = "border-b border-zinc-700 hover:bg-zinc-700/50";

                    // Crear las celdas para cada producto
                    const cells = [
                        row.insertCell(0),
                        row.insertCell(1),
                        row.insertCell(2),
                        row.insertCell(3),
                        row.insertCell(4)
                    ];

                    // Añadir contenido y estilos a las celdas
                    cells.forEach(cell => {
                        cell.className = "p-4 text-gray-300";
                    });

                    cells[0].textContent = producto.id;
                    cells[1].textContent = producto.nombre;
                    cells[2].textContent = producto.descripcion;
                    cells[3].textContent = producto.precio;
                    cells[4].textContent = producto.stock;
                });
            })
            .catch(error => console.error('Error al cargar los productos:', error));
    </script>
</body>
</html> 