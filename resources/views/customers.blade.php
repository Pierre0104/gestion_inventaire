<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <title>Gestion de clients</title>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Gestion des Clients</h1>
        
        <section class="mb-8">
            <h2 class="text-2xl text-gray-700 mb-4">Ajouter un Nouveau Client</h2>
            <div class="bg-white rounded shadow-md p-6">
                <form id="create-customer">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-name">
                            Nom
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-name" type="text" placeholder="Nom du client" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-email">
                            email
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-email" placeholder="Email du client"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-phone">
                            Téléphone
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-phone" type="text" placeholder="Numéro de téléphone du client" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-address">
                            Adresse
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-address" type="text" placeholder="Adresse du client" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Ajouter
                        </button>
                    </div>
                        
                </form>
            </div>
        </section>
        
       <section id="customers" class="mb-8">
            <h2 class="text-lg font-semibold text-gray-600 mb-3">Clients</h2>
             <div id="customers-list" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Les produits seront ajoutés ici par JavaScript -->
            </div>
         </section>

        </section>
        
     <div id="edit-customers-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Modifier un Client
                        </h3>
                        <form id="update-customers" class="mt-2">
                            <input type="hidden" id="edit-id">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-name" type="text" placeholder="Nom du client" required>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-email" placeholder="Email du client"></textarea>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-phone" type="text"  placeholder="Téléphone du client" required>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-address" type="text" placeholder="Adresse du client" required>
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

<div id="pagination-controls" class="mt-4 flex justify-center">
    <!-- Buttons will be added here by updatePaginationControls() -->
</div>

<!-- inventory.blade.php -->
<div class="flex justify-end space-x-2 mb-4">
    <a href="{{ url('inventory/orders') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Commandes
    </a>
    <a href="{{ url('inventory/') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Produits
    </a>
    <a href="{{ url('inventory/suppliers') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les fournisseurs
    </a>
</div>




    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchCustomers();
            // Autres fonctions fetch pour les commandes, clients, etc.
        });

    function fetchCustomers(page = 1) {
    fetch(`/api/customers?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const customerList = document.getElementById('customers-list');
            customerList.innerHTML = '';
            data.data.forEach(customers => {
                customerList.innerHTML += `
                    <div class="flex justify-between items-center p-3 border-b border-gray-200">
                        <span class="text-gray-800">${customers.name} - ${customers.email}</span>
                        <div>
                            <button onclick="editCustomers(${customers.id})" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Modifier</button>
                            <button onclick="deleteCustomers(${customers.id})" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Supprimer</button>
                        </div>
                    </div>
                `;
            });
            // Pagination controls
            updatePaginationControls(data);
        })
        .catch(error => console.error('Erreur:', error));
}

function updatePaginationControls(data) {
    const paginationControls = document.getElementById('pagination-controls');
    paginationControls.innerHTML = '';
    if (data.prev_page_url) {
        paginationControls.innerHTML += `<button onclick="fetchCustomers(${data.current_page - 1})">Prev</button>`;
    }
    if (data.next_page_url) {
        paginationControls.innerHTML += `<button onclick="fetchCustomers(${data.current_page + 1})">Next</button>`;
    }
}


    function showEditModal() {
        document.getElementById('edit-customers-modal').classList.remove('hidden');
    }

   
   function editCustomers(customerId) {
            fetch(`/api/customers/${customerId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Produit non trouvé');
                    return response.json();
                })
                .then(customers => {
                    // Assurez-vous que votre modal est présent dans le DOM ici
                    const editModal = document.getElementById('edit-customers-modal');
                    const editForm = editModal.querySelector('form');
                    editForm.querySelector('#edit-id').value = customers.id;
                    editForm.querySelector('#edit-name').value = customers.name;
                    editForm.querySelector('#edit-email').value = customers.email;
                    editForm.querySelector('#edit-phone').value = customers.phone;
                    editForm.querySelector('#edit-address').value = customers.address;
                    editModal.classList.remove('hidden');
                })
                .catch(error => console.error('Erreur:', error));
        }

        function hideEditModal() {
            const editModal = document.getElementById('edit-customers-modal');
            editModal.classList.add('hidden');
        }


function updateCustomers(event) {
    event.preventDefault();
    const id = document.getElementById('edit-id').value;
    const name = document.getElementById('edit-name').value;
    const email = document.getElementById('edit-email').value;
    const phone = document.getElementById('edit-phone').value;
    const adress = document.getElementById('edit-address').value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/api/customers/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, email, phone, adress })
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur lors de la mise à jour du client');
        return response.json();
    })
    .then(updatedCustomers => {
        fetchCustomers(); // Recharger la liste des produits
        document.getElementById('edit-customers-modal').classList.add('hidden');
        document.getElementById('update-customers').reset();

        hideEditModal(); // Cacher le modal après la mise à jour
    })
    .catch(error => console.error('Erreur:', error));
}

document.getElementById('update-customers').addEventListener('submit', updateCustomers);
document.getElementById('create-customer').addEventListener('submit', createCustomer);

function createCustomer(event) {
    event.preventDefault();
    const name = document.getElementById('add-name').value;
    const email = document.getElementById('add-email').value;
    const phone = document.getElementById('add-phone').value;
    const address = document.getElementById('add-address').value;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/api/customers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, email, phone, address })
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur lors de l'ajout du client");
        return response.json();
    })
    .then(createCustomer => {
        fetchCustomers(); // Recharger la liste des produits
        document.getElementById('create-customer').classList.add('hidden');
        document.getElementById('create-customer').reset();
    })
    .catch(error => console.error('Erreur:', error));
}
        document.getElementById('update-customers').addEventListener('submit', updateCustomers); 
        
    function deleteCustomers(customerId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
        fetch(`/api/customers/${customerId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la suppression du client');
            return response.json();
        })
        .then(() => {
            fetchCustomers(); // Mettre à jour la liste des produits après la suppression
            alert('Client supprimé avec succès.');
        })
        .catch(error => console.error('Erreur:', error));
    }
}

    </script>

</body>
</html>
