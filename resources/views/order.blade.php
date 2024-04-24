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
        
       <div class="flex justify-between mb-4">
            <button onclick="window.location.href='/inventory'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Retour à l'inventaire
            </button>
            <button onclick="fetchOrders()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Rafraîchir les commandes
            </button>
        </div>
        
        <div id="orders-list" class="mt-8"></div>
    <!-- Ajoutez ce formulaire dans votre <div class="container mx-auto py-8"> -->
<!-- Bouton pour ouvrir le modal de création d'une commande -->
<button onclick="showCreateOrderModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
    Créer une Commande
</button>

<!-- Modal pour créer une nouvelle commande -->
<div id="create-order-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            Nouvelle Commande
                        </h3>
                        <div>
                            <form id="create-order-form">
                                <input type="number" id="new-customer-id" placeholder="ID Client" required />
                                <input type="date" id="new-order-date" placeholder="Date de commande" required />
                                <input type="number" id="new-total-price" placeholder="Prix Total" required />
                                <!-- Ajoutez d'autres champs si nécessaire -->
                                <div class="mt-5 sm:mt-6">
                                    <button type="button" onclick="createOrder()" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Créer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="hideCreateOrderModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal pour modifier une commande existante -->
<div id="edit-order-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline-edit">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline-edit">
                            Modifier Commande
                        </h3>
                        <div class="mt-2">
                            <form id="edit-order-form">
                                <input type="hidden" id="edit-order-id">
                                <input type="number" id="edit-customer-id" placeholder="ID Client" required />
                                <input type="date" id="edit-order-date" placeholder="Date de commande" required />
                                <input type="number" id="edit-total-price" placeholder="Prix Total" required />
                                <!-- Ajoutez d'autres champs si nécessaire -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitEditOrder()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Enregistrer
                </button>
                <button type="button" onclick="hideEditOrderModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-center mt-4 space-x-2">
    <button id="prevPageBtn" onclick="goToPreviousPage()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
        Précédent
    </button>
    <button id="nextPageBtn" onclick="goToNextPage()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
        Suivant
    </button>
</div>


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
