<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <title>Gestion d'Inventaire</title>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Gestion d'Inventaire</h1>
        
        <section class="mb-8">
            <h2 class="text-2xl text-gray-700 mb-4">Ajouter un Nouveau Produit</h2>
            <div class="bg-white rounded shadow-md p-6">
                <form id="create-product">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-name">
                            Nom du produit
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-name" type="text" placeholder="Nom du produit" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-description">
                            Description du produit
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-description" placeholder="Description du produit"></textarea>
                    </div>
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="add-price">
                                Prix
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-price" type="number" step="0.01" placeholder="Prix" required>
                        </div>
                        <div class="w-1/2 ml-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="add-stock">
                                Stock
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-stock" type="number" placeholder="Stock" required>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="add-supplier-id">
                            ID du fournisseur
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="add-supplier-id" type="number" placeholder="ID du fournisseur" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </section>
        
       <section id="products" class="mb-8">
            <h2 class="text-lg font-semibold text-gray-600 mb-3">Produits</h2>
             <div id="product-list" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Les produits seront ajoutés ici par JavaScript -->
            </div>
         </section>

        </section>
        
     <div id="edit-product-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Modifier un Produit
                        </h3>
                        <form id="update-product" class="mt-2">
                            <input type="hidden" id="edit-id">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-name" type="text" placeholder="Nom du produit" required>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-description" placeholder="Description du produit"></textarea>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-price" type="number" step="0.01" placeholder="Prix" required>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-stock" type="number" placeholder="Stock" required>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="edit-supplier-id" type="number" placeholder="ID du fournisseur" required>
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
<div class="text-right mb-4">
    <a href="{{ url('inventory/order') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Commandes
    </a>
    <a href="{{ url('inventory/customers') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Gérer les Clients
    </a>
</div>



    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchProducts();
            // Autres fonctions fetch pour les commandes, clients, etc.
        });

    function fetchProducts(page = 1) {
    fetch(`/api/products?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';
            data.data.forEach(product => {
                productList.innerHTML += `
                    <div class="flex justify-between items-center p-3 border-b border-gray-200">
                        <span class="text-gray-800">${product.name} - ${product.price.toFixed(2)}€</span>
                        <div>
                            <button onclick="editProduct(${product.id})" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Modifier</button>
                            <button onclick="deleteProduct(${product.id})" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded focus:outline-none focus:shadow-outline">Supprimer</button>
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
        paginationControls.innerHTML += `<button onclick="fetchProducts(${data.current_page - 1})">Prev</button>`;
    }
    if (data.next_page_url) {
        paginationControls.innerHTML += `<button onclick="fetchProducts(${data.current_page + 1})">Next</button>`;
    }
}


    function showEditModal() {
        document.getElementById('edit-product-modal').classList.remove('hidden');
    }

   
   function editProduct(productId) {
            fetch(`/api/products/${productId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Produit non trouvé');
                    return response.json();
                })
                .then(product => {
                    // Assurez-vous que votre modal est présent dans le DOM ici
                    const editModal = document.getElementById('edit-product-modal');
                    const editForm = editModal.querySelector('form');
                    editForm.querySelector('#edit-id').value = product.id;
                    editForm.querySelector('#edit-name').value = product.name;
                    editForm.querySelector('#edit-description').value = product.description || '';
                    editForm.querySelector('#edit-price').value = product.price;
                    editForm.querySelector('#edit-stock').value = product.stock;
                    editForm.querySelector('#edit-supplier-id').value = product.supplier_id;
                    editModal.classList.remove('hidden');
                })
                .catch(error => console.error('Erreur:', error));
        }

        function hideEditModal() {
            const editModal = document.getElementById('edit-product-modal');
            editModal.classList.add('hidden');
        }


function updateProduct(event) {
    event.preventDefault();
    const id = document.getElementById('edit-id').value;
    const name = document.getElementById('edit-name').value;
    const description = document.getElementById('edit-description').value;
    const price = parseFloat(document.getElementById('edit-price').value);
    const stock = parseInt(document.getElementById('edit-stock').value, 10);
    const supplier_id = parseInt(document.getElementById('edit-supplier-id').value, 10);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/api/products/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, description, price, stock, supplier_id })
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur lors de la mise à jour du produit');
        return response.json();
    })
    .then(updatedProduct => {
        fetchProducts(); // Recharger la liste des produits
        document.getElementById('edit-product-modal').classList.add('hidden');
        document.getElementById('update-product').reset();

        hideEditModal(); // Cacher le modal après la mise à jour
    })
    .catch(error => console.error('Erreur:', error));
}

document.getElementById('update-product').addEventListener('submit', updateProduct);

function createProduct(event) {
    event.preventDefault();
    const name = document.getElementById('add-name').value;
    const description = document.getElementById('add-description').value;
    const price = parseFloat(document.getElementById('add-price').value);
    const stock = parseInt(document.getElementById('add-stock').value, 10);
    const supplier_id = parseInt(document.getElementById('add-supplier-id').value, 10);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/api/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, description, price, stock, supplier_id })
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur lors de l'ajout du produit");
        return response.json();
    })
    .then(createProduct => {
        fetchProducts(); // Recharger la liste des produits
        document.getElementById('create-product').classList.add('hidden');
        document.getElementById('create-product').reset();
    })
    .catch(error => console.error('Erreur:', error));
}
        document.getElementById('update-product').addEventListener('submit', updateProduct); 

    function deleteProduct(productId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        fetch(`/api/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la suppression du produit');
            return response.json();
        })
        .then(() => {
            fetchProducts(); // Mettre à jour la liste des produits après la suppression
            alert('Produit supprimé avec succès.');
        })
        .catch(error => console.error('Erreur:', error));
    }
}

    </script>

</body>
</html>
