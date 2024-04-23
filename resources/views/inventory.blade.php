<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion d'Inventaire</title>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>

    <h1>Gestion d'Inventaire</h1>

    <section id="add-product-form">
    <h2>Ajouter un Nouveau Produit</h2>
    <form id="create-product">
        <input type="text" id="add-name" placeholder="Nom du produit" required>
        <textarea id="add-description" placeholder="Description du produit"></textarea>
        <input type="number" id="add-price" placeholder="Prix" required>
        <input type="number" id="add-stock" placeholder="Stock" required>
        <input type="number" id="add-supplier-id" placeholder="ID du fournisseur" required>
        <button type="submit">Ajouter le produit</button>
    </form>
</section>
    
    <section id="products">
        <h2>Produits</h2>
        <div id="product-list"></div>
    </section>
    
    <!-- Formulaire de modification d'un produit -->
    <section id="edit-product-form" class="hidden">
        <h2>Modifier un Produit</h2>
        <form id="update-product">
            <input type="hidden" id="edit-id">
            <input type="text" id="edit-name" placeholder="Nom du produit" required>
            <textarea id="edit-description" placeholder="Description du produit"></textarea>
            <input type="number" id="edit-price" placeholder="Prix" required>
            <input type="number" id="edit-stock" placeholder="Stock" required>
            <input type="number" id="edit-supplier-id" placeholder="ID du fournisseur" required>
            <button type="submit">Sauvegarder les modifications</button>
        </form>
    </section>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchProducts();
            // Autres fonctions fetch pour les commandes, clients, etc.
        });

        function fetchProducts() {
            fetch('/api/products')
                .then(response => response.json())
                .then(products => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = '';
                    products.forEach(product => {
                        productList.innerHTML += `
                            <div id="product-${product.id}">
                                <span>${product.name} - ${product.price}€</span>
                                <button onclick="editProduct(${product.id})">Modifier</button>
                                <button onclick="deleteProduct(${product.id})">Supprimer</button>
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }


        function editProduct(productId) {
    fetch(`/api/products/${productId}`)
        .then(response => {
            if (!response.ok) throw new Error('Produit non trouvé');
            return response.json();
        })
        .then(product => {
            document.getElementById('edit-id').value = product.id;
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-description').value = product.description || '';
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-stock').value = product.stock;
            document.getElementById('edit-supplier-id').value = product.supplier_id;
            document.getElementById('edit-product-form').classList.remove('hidden');
        })
        .catch(error => console.error('Erreur:', error));
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
        document.getElementById('edit-product-form').classList.add('hidden');
        document.getElementById('edit-product-form').reset();
    })
    .catch(error => console.error('Erreur:', error));
}

document.getElementById('create-product').addEventListener('submit', createProduct);

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
    </script>

</body>
</html>
