{{-- order.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Gestion des Commandes</h1>
        
        <!-- Liste des commandes -->
        <div id="orders-list">
            
        </div>
        
        <!-- Pagination -->
        <div id="pagination-controls" class="mt-4">
            
        </div>

        <div id="edit-order-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Modifier un order
                        </h3>
                        <form id="update-order" class="mt-2">
                            <input type="hidden" id="edit-order-id">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-customer-id" type="number" step="1" placeholder="id client" required>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-order-date" placeholder="Description du produit"></textarea>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-total-price" type="number" step="0.01" placeholder="Prix" required>
                            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Valider
                                </button>
                                <button type="button" onclick="hideEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Quitter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- inventory.blade.php -->
<!-- inventory.blade.php -->
<div class="flex justify-end space-x-2 mb-4">
    <a href="{{ url('inventory/customers') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Clients
    </a>
    <a href="{{ url('inventory/') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Produits
    </a>
    <a href="{{ url('inventory/suppliers') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les fournisseurs
    </a>
</div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchOrders();  // Charge les commandes dès que la page est chargée
        });


        function updatePaginationControls(data) {
    const paginationControls = document.getElementById('pagination-controls');
    paginationControls.innerHTML = '';
    if (data.prev_page_url) {
        paginationControls.innerHTML += `<button onclick="fetchOrders(${data.current_page - 1})">Prev</button>`;
    }
    if (data.next_page_url) {
        paginationControls.innerHTML += `<button onclick="fetchOrders(${data.current_page + 1})">Next</button>`;
    }
}

function fetchOrders(page = 1) {
    fetch(`/api/orders?page=${page}`)
    .then(response => response.json())
    .then(response => {
        console.log(response); // Log the response to inspect the structure
        const ordersList = document.getElementById('orders-list');
        ordersList.innerHTML = '';

          response.data.forEach(order => {
            const orderDate = order.order_date ? order.order_date.substring(0, 10) : 'Non spécifiée';
            ordersList.innerHTML += `
                <div class="p-3 bg-white rounded shadow mb-2">
                    Commande ID: ${order.id}, Client ID: ${order.customer_id}, Date: ${orderDate}, Total: ${order.total_price}€
                    <button onclick="deleteOrder(${order.id})" class="ml-2 bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Supprimer</button>
                    <button onclick="showEditOrderModal(${order.id})" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Modifier</button>
                </div>
            `;
        });

        currentPage = response.current_page;
        const lastPage = response.last_page;

        updatePaginationControls(response);
    })
    .catch(error => console.error('Erreur:', error));
}

// These functions update the current page and then fetch the orders
function goToPreviousPage() {
    if (currentPage > 1) {
        fetchOrders(currentPage - 1);
    }
}

function goToNextPage() {
    fetch('/api/orders')
    .then(response => response.json())
    .then(response => {
        if (currentPage < response.last_page) {
            fetchOrders(currentPage + 1);
        }
    })
    .catch(error => console.error('Erreur:', error));
}


        function deleteOrder(orderId) {
            fetch(`/api/orders/${orderId}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(message => {
                alert(message.message);
                fetchOrders();  // Recharge les commandes après suppression
            })
            .catch(error => console.error('Erreur:', error));
        }

        function editOrderModal(orderId) {
            // Implémentez un modal pour modifier les détails de la commande
        }
function showCreateOrderModal() {
    // Reset the form to clear all inputs
    document.getElementById('create-order-form').reset();
    document.getElementById('create-order-modal').classList.remove('hidden');
}


function hideCreateOrderModal() {
    document.getElementById('create-order-modal').classList.add('hidden');
}

function createOrder() {
    const customerId = document.getElementById('new-customer-id').value;
    const orderDate = document.getElementById('new-order-date').value;
    const totalPrice = document.getElementById('new-total-price').value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/api/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            customer_id: customerId,
            order_date: orderDate,
            total_price: totalPrice
        })
    })
    .then(response => response.json())
    .then(newOrder => {
        fetchOrders(); // Recharger les commandes
        hideCreateOrderModal(); // Fermer le modal
    })
    .catch(error => console.error('Erreur:', error));
}


function submitEditOrder(event) {
    event.preventDefault();
    const orderId = document.getElementById('edit-order-id').value;
    const customer_id = parseInt(document.getElementById('edit-customer-id').value, 10);
    const order_date = document.getElementById('edit-order-date').value;
    const total_price = parseFloat(document.getElementById('edit-total-price').value);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    console.log(orderId)
    fetch(`/api/orders/${orderId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ customer_id, order_date, total_price })
    })
    .then(response => response.json())
    .then(updatedOrder => {
        alert('La commande a été mise à jour.');
        fetchOrders(); // Recharger les commandes
        hideEditModal(); // Fermer le modal
    })
    .catch(error => console.error('Erreur:', error));
}
function showEditOrderModal(orderId) {
    // Fetch the order details from the server by ID
    fetch(`/api/orders/${orderId}`)
        .then(response => response.json())
        .then(order => {
            const editModal = document.getElementById('edit-order-modal');
            editModal.querySelector('#edit-order-id').value = order.id;
            editModal.querySelector('#edit-customer-id').value = order.customer_id;
            editModal.querySelector('#edit-order-date').value = order.order_date ? order.order_date.substring(0, 10) : '';
            editModal.querySelector('#edit-total-price').value = order.total_price;
            editModal.classList.remove('hidden');
        })
        .catch(error => console.error('Erreur:', error));
}



function hideEditModal() {
    document.getElementById('edit-order-modal').classList.add('hidden');
}

document.getElementById('update-order').addEventListener('submit', submitEditOrder);
    </script>
</body>
</html>
