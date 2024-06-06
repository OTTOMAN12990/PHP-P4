<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling plaatsen</title>
    <script>
        let productIndex = 1; // Start at 2 since we already have inputs for product 1 and 2

        function addProductInput() {
            const productContainer = document.getElementById('product-container');

            const productDiv = document.createElement('div');

            const productIdLabel = document.createElement('label');
            productIdLabel.setAttribute('for', 'product_id_' + productIndex);
            productIdLabel.textContent = 'Product ID ' + productIndex + ':';

            const productIdInput = document.createElement('input');
            productIdInput.setAttribute('type', 'text');
            productIdInput.setAttribute('id', 'product_id_' + productIndex);
            productIdInput.setAttribute('name', 'products[' + (productIndex - 1) + '][product_id]');
            productIdInput.setAttribute('value', '');

            const quantityLabel = document.createElement('label');
            quantityLabel.setAttribute('for', 'quantity_' + productIndex);
            quantityLabel.textContent = ' Quantity:';

            const quantityInput = document.createElement('input');
            quantityInput.setAttribute('type', 'text');
            quantityInput.setAttribute('id', 'quantity_' + productIndex);
            quantityInput.setAttribute('name', 'products[' + (productIndex - 1) + '][quantity]');
            quantityInput.setAttribute('value', '');

            productDiv.appendChild(productIdLabel);
            productDiv.appendChild(productIdInput);
            productDiv.appendChild(quantityLabel);
            productDiv.appendChild(quantityInput);

            productContainer.appendChild(productDiv);

            productIndex++;
        }
    </script>
</head>
<body>
    <h1>Bestelling plaatsen</h1>
    <form action="scripts/place_order.php" method="post">
        <div id="product-container">
            <div>
                <label for="product_id_1">Product ID 1:</label>
                <input type="text" id="product_id_1" name="products[0][product_id]" value="">
                <label for="quantity_1"> Quantity:</label>
                <input type="text" id="quantity_1" name="products[0][quantity]" value="">
            </div>
            
        </div>
        <button type="button" onclick="addProductInput()">Meer producten toevoegen</button>
        <button type="submit">Bestelling plaatsen</button>
    </form>
</body>
</html>
