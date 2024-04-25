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
            @foreach ($orders as $order)
                <div class="flex justify-between items-center p-3 mb-4 bg-white rounded shadow">
                    <div>
                        <p>Commande ID: {{ $order->id }}</p>
                        <p>Client ID: {{ $order->customer_id }}</p>
                        <p>Date de commande: {{ $order->order_date->format('d/m/Y') }}</p>
                        <p>Total: {{ number_format($order->total_price, 2, ',', ' ') }} €</p>
                    </div>
                    <div>
                        <button onclick="showEditOrderModal({{ $order->id }})" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Modifier</button>
                        <button onclick="deleteOrder({{ $order->id }})" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Supprimer</button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>

<!-- inventory.blade.php -->
<!-- inventory.blade.php -->
<div class="text-center mb-4 space-x-2">
    <a href="{{ url('inventory/suppliers') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
        Gérer les Fournisseurs
    </a>
    <a href="{{ url('inventory/') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Produits
    </a>
</div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchOrders();  // Charge les commandes dès que la page est chargée
        });


 function updatePaginationControls(currentPage, lastPage) {
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');

    prevPageBtn.disabled = currentPage <= 1;
    nextPageBtn.disabled = currentPage >= lastPage;
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

        updatePaginationControls(currentPage, lastPage);
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


function submitEditOrder() {
    const orderId = parseInt(document.getElementById('edit-order-id').value, 10);
    const customerId = parseInt(document.getElementById('edit-customer-id').value, 10);
    const orderDate = document.getElementById('edit-order-date').value;
    const totalPrice = parseFloat(document.getElementById('edit-total-price').value);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/api/orders/${orderId}`, {
        method: 'PUT',
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
    .then(updatedOrder => {
        alert('La commande a été mise à jour.');
        fetchOrders(); // Recharger les commandes
        hideEditOrderModal(); // Fermer le modal
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



function hideEditOrderModal() {
    document.getElementById('edit-order-modal').classList.add('hidden');
}
    </script>
</body>
</html>
