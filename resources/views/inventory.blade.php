<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion d'Inventaire</title>
</head>
<body>

    <h1>Gestion d'Inventaire</h1>
    
    <section id="products">
        <h2>Produits</h2>
        <div id="product-list"></div>
    </section>
    
    <!-- Plus de sections pour les commandes, clients, etc. -->
    
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
                        productList.innerHTML += `<div>${product.name} - ${product.price}€</div>`;
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }

        // Fonctions fetch pour obtenir les commandes, clients, etc.
    </script>

</body>
</html>
