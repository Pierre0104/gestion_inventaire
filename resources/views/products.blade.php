<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Produits</title>
</head>
<body>

    <h1>Gestion des Produits</h1>
    
    <!-- Formulaire pour ajouter un nouveau produit -->
    <div>
        <h2>Ajouter un Produit</h2>
        <form id="add-product-form">
            <input type="text" id="add-name" placeholder="Nom du produit" required>
            <input type="text" id="add-description" placeholder="Description">
            <input type="number" step="0.01" id="add-price" placeholder="Prix" required>
            <input type="number" id="add-stock" placeholder="Stock" required>
            <input type="number" id="add-supplier-id" placeholder="ID du fournisseur" required>
            <button type="submit">Ajouter</button>
        </form>

    </div>

    <!-- Formulaire pour modifier un produit existant -->
    <div style="display:none;" id="edit-product-section">
        <h2>Modifier un Produit</h2>
        <form id="edit-product-form">
            <input type="hidden" id="edit-id">
            <input type="text" id="edit-name" placeholder="Nom du produit" required>
            <input type="text" id="edit-description" placeholder="Description">
            <input type="number" id="edit-price" placeholder="Prix" required>
            <input type="number" id="edit-stock" placeholder="Stock" required>
            <button type="submit">Modifier</button>
            <button type="button" onclick="hideEditSection()">Annuler</button>
        </form>
    </div>

    <!-- Liste des produits -->
    <div id="products-list"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchProducts();
        });

       // Stockez les produits dans une variable globale
var globalProducts = [];

function fetchProducts() {
    fetch('/api/products')
        .then(response => response.json())
        .then(products => {
            globalProducts = products; // Stockez les produits pour y accéder plus tard
            const productList = document.getElementById('products-list');
            productList.innerHTML = '';
            products.forEach(product => {
                productList.innerHTML += `<div>${product.name} - ${product.price}€ <button onclick="showEditProduct(${product.id})">Modifier</button> <button onclick="deleteProduct(${product.id})">Supprimer</button></div>`;
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function showEditProduct(productId) {
    const product = globalProducts.find(p => p.id === productId);
    if (product) {
        editProduct(product);
    }
}

function editProduct(product) {
    document.getElementById('edit-id').value = product.id;
    document.getElementById('edit-name').value = product.name;
    document.getElementById('edit-description').value = product.description;
    document.getElementById('edit-price').value = product.price;
    document.getElementById('edit-stock').value = product.stock;
    document.getElementById('edit-product-section').style.display = 'block';
}


     function addProduct(event) {
    event.preventDefault();
    const name = document.getElementById('add-name').value;
    const description = document.getElementById('add-description').value;
    const price = parseFloat(document.getElementById('add-price').value); // Convertit en nombre flottant
    const stock = parseInt(document.getElementById('add-stock').value, 10); // Convertit en entier
    const supplier_id = parseInt(document.getElementById('add-supplier-id').value, 10); // Convertit en entier, ajoutez l'élément à votre formulaire

    fetch('/api/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ name, description, price, stock, supplier_id })
    })
    .then(response => {
        if(!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json(); // ou .text() si la réponse n'est pas du JSON
    })
    .then(product => {
        fetchProducts();
        document.getElementById('add-product-form').reset();
    })
    .catch(error => console.error('Erreur:', error));
}



        // function editProduct(product) {
        //     document.getElementById('edit-id').value = product.id;
        //     document.getElementById('edit-name').value = product.name;
        //     document.getElementById('edit-description').value = product.description;
        //     document.getElementById('edit-price').value = product.price;
        //     document.getElementById('edit-stock').value = product.stock;
        //     document.getElementById('edit-product-section').style.display = 'block';
        // }

        function updateProduct(event) {
            event.preventDefault();
            const id = document.getElementById('edit-id').value;
            const name = document.getElementById('edit-name').value;
            const description = document.getElementById('edit-description').value;
            const price = document.getElementById('edit-price').value;
            const stock = document.getElementById('edit-stock').value;

            fetch('/api/products/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name, description, price, stock })
            })
            .then(response => response.json())
            .then(product => {
                fetchProducts();
                hideEditSection();
            })
            .catch(error => console.error('Erreur:', error));
        }

        function deleteProduct(productId) {
            fetch('/api/products/' + productId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(response => {
                fetchProducts();
            })
            .catch(error => console.error('Erreur:', error));
        }

        function hideEditSection() {
            document.getElementById('edit-product-section').style.display = 'none';
        }

        document.getElementById('add-product-form').addEventListener('submit', addProduct);
        document.getElementById('edit-product-form').addEventListener('submit', updateProduct);
    </script>

</body>
</html>
