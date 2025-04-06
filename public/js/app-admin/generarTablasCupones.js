document.addEventListener('DOMContentLoaded', function(event){

    let allCupones = []; // Store all cupones

    // Function to filter cupones
    function filterCupones() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        const filteredCupones = allCupones.filter(cupon => {
            return cupon.codigo.toLowerCase().includes(searchTerm);
        });

        updateTable(filteredCupones);
    }

    // Function to update the table with filtered cupones
    function updateTable(cupones) {
        const tablaCupones = document.getElementById('tabla-cupones').getElementsByTagName('tbody')[0];
        tablaCupones.innerHTML = ''; // Clear current table

        cupones.forEach(cupon => {
            const row = tablaCupones.insertRow();
            row.className = "border-b border-zinc-700 hover:bg-zinc-700/50";

            // Crear celdas con clases responsivas
            const cells = [
                row.insertCell(0), // ID
                row.insertCell(1), // Código
                row.insertCell(2), // Descuento
                row.insertCell(3)  // Acciones
            ];

            // Aplicar clases base a todas las celdas
            cells.forEach(cell => {
                cell.className = "p-4 text-gray-300";
            });

            cells[0].textContent = cupon.id;
            cells[1].textContent = cupon.codigo;
            cells[2].textContent = `${cupon.descuento}%`;

            // Crear contenedor para los iconos de acciones
            const accionesContainer = document.createElement('div');
            accionesContainer.className = 'flex items-center gap-3';

            // Icono de Ver


            // Icono de Editar
            const editarBtn = document.createElement('button');
            editarBtn.className = 'text-yellow-400 hover:text-yellow-300';
            editarBtn.setAttribute('aria-label', `Editar cupón ${cupon.codigo}`);
            editarBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            `;
            editarBtn.onclick = () => editarCupon(cupon.id);

            // Icono de Eliminar
            const eliminarBtn = document.createElement('button');
            eliminarBtn.className = 'text-red-400 hover:text-red-300';
            eliminarBtn.setAttribute('aria-label', `Eliminar cupón ${cupon.codigo}`);
            eliminarBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            `;
            eliminarBtn.onclick = () => eliminarCupon(cupon.id);

            accionesContainer.appendChild(editarBtn);
            accionesContainer.appendChild(eliminarBtn);
            cells[3].appendChild(accionesContainer);
        });
    }

    // Initial data load
    fetch('/api/cupones')
        .then(response => response.json())
        .then(data => {
            allCupones = data;
            
            // Initial table population
            updateTable(data);
        })
        .catch(error => console.error('Error al cargar los cupones:', error));

    // Add event listeners for search
    document.getElementById('searchInput').addEventListener('input', filterCupones);


    function editarCupon(id) {
        window.location.href = `/cupones/${id}/edit`;
    }

    function eliminarCupon(id) {
        // Find the coupon code for the confirmation message
        const cuponToDelete = allCupones.find(c => c.id === id);
        const cuponCode = cuponToDelete ? cuponToDelete.codigo : 'este cupón';

        if (confirm(`¿Estás seguro de que deseas eliminar el cupón ${cuponCode}?`)) {
            fetch(`cupones/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                 // Check if the response is JSON before parsing
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json().then(data => ({ ok: response.ok, status: response.status, body: data }));
                } else {
                    return response.text().then(text => ({ ok: response.ok, status: response.status, body: text }));
                }
            })
            .then(result => {
                if (result.ok) {
                    console.log('Cupón eliminado:', result.body);
                    // Remove coupon from allCupones array
                    allCupones = allCupones.filter(cupon => cupon.id !== id);
                    // Update the table with the filtered cupones
                    filterCupones();
                } else {
                    console.error('Error al eliminar el cupón:', result.status, result.body);
                    // Provide more specific feedback if possible
                    const errorMessage = (result.body && result.body.message) ? result.body.message : `Error ${result.status}`;
                    alert(`Error al eliminar el cupón: ${errorMessage}`);
                }
            })
            .catch(error => {
                console.error('Error en fetch:', error);
                alert('Ocurrió un error de red al intentar eliminar el cupón.');
            });
        }
    }
});