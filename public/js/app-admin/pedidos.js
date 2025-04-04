document.addEventListener('DOMContentLoaded', function(event){
    
    let allOrders = []; // Store all orders
    
    // Function to filter orders
    function filterOrders() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const selectedStatus = document.getElementById('statusFilter').value.toLowerCase();
        
        const filteredOrders = allOrders.filter(order => {
            const matchesSearch = order.id.toString().includes(searchTerm) || 
                                 (order.created_at && order.created_at.toLowerCase().includes(searchTerm));
            const matchesStatus = selectedStatus === '' || 
                                 order.estado.toLowerCase() === selectedStatus;
            return matchesSearch && matchesStatus;
        });

        updateTable(filteredOrders);
    }

    // Function to update the table with filtered orders
    function updateTable(orders) {
        const tablaPedidos = document.getElementById('tabla-pedidos').getElementsByTagName('tbody')[0];
        tablaPedidos.innerHTML = ''; // Clear current table

        orders.forEach(pedido => {
            const row = tablaPedidos.insertRow();
            row.className = "border-b border-zinc-700 hover:bg-zinc-700/50";

            // Create cells
            const cells = [
                row.insertCell(0), // ID
                row.insertCell(1), // Fecha
                row.insertCell(2), // Total
                row.insertCell(3)  // Estado
            ];

            cells.forEach(cell => {
                cell.className = "p-4 text-gray-300";
            });

            // Format date
            const fecha = pedido.created_at ? new Date(pedido.created_at) : null;
            const fechaFormateada = fecha ? `${fecha.getDate().toString().padStart(2, '0')}/${(fecha.getMonth() + 1).toString().padStart(2, '0')}/${fecha.getFullYear()}` : 'N/A';

            // Fill cells with data
            cells[0].textContent = pedido.id;
            cells[1].textContent = fechaFormateada;
            cells[2].textContent = `${parseFloat(pedido.total).toFixed(2)} €`;
            
            // Create status dropdown
            const form = document.createElement('form');
            form.action = `pedidos/${pedido.id}`;
            form.method = 'POST';
            form.className = 'm-0';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfToken);
            
            // Add method PUT
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);
            
            // Create status dropdown
            const selectEl = document.createElement('select');
            selectEl.name = 'estado';
            selectEl.className = 'estado-pedido bg-zinc-700 text-white border border-zinc-600 rounded px-2 py-1 text-sm w-full';
            selectEl.onchange = function() { form.submit(); };
            
            // Add status options
            const estados = ['pendiente', 'enviado', 'entregado', 'cancelado'];
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado;
                option.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
                option.selected = pedido.estado === estado;
                selectEl.appendChild(option);
            });
            
            form.appendChild(selectEl);
            cells[3].appendChild(form);
        });
    }

    // Initial data load - we'll get the data from the table that's already rendered
    const tableRows = document.getElementById('tabla-pedidos').getElementsByTagName('tbody')[0].rows;
    allOrders = Array.from(tableRows).map(row => {
        const estadoSelect = row.cells[3].querySelector('select');
        
        return {
            id: row.cells[0].textContent.trim(),
            created_at: row.cells[1].textContent.trim(),
            total: parseFloat(row.cells[2].textContent.replace('€', '').trim()),
            estado: estadoSelect ? estadoSelect.value : ''
        };
    });

    // Add event listeners for search and filter
    document.getElementById('searchInput').addEventListener('input', filterOrders);
    document.getElementById('statusFilter').addEventListener('change', filterOrders);
});