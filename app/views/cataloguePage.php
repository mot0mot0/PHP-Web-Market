<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link rel="stylesheet" href="/assets/styles/cataloguePage.css">
    <link rel="stylesheet" href="/assets/styles/navbar.css">
</head>
<body>
    <header>
        <h1>Магазин кайфовых товаров</h1>
    </header>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main>
        <?php 
            if (isset($_SESSION['error'])) {
                $message = $_SESSION['error'];
                echo "<script>alert('$message');</script>";
                unset($_SESSION['error']);
            };
            if (isset($_SESSION['success'])) {
                $message = $_SESSION['success'];
                echo "<script>alert('$message');</script>";
                unset($_SESSION['success']);
            }
        ?>

        <div class="products-container">
            <?php
            foreach ($products as $product) {
                displayProductCard($product);
            }

            function displayProductCard($product) {
                $isAvailable = $product['count'] > 0;
                $buyButtonDisabled = !$isAvailable ? 'disabled' : '';

                echo '<div class="product-card">';
                echo '<img src="' . $product['picture'] . '" alt="' . htmlspecialchars($product['name']) . '" class="product-image">';
                echo '<div class="product-content">';
                echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                echo '<p class="price">' . number_format($product['price'], 2) . ' ₽</p>';
                echo '<p>' . htmlspecialchars($product['description']) . '</p>';
                echo '<p>В наличии: ' . $product['count'] . '</p>';
                echo '<form method="POST" action="/cataloguePage/placeOrder">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($product['id']) . '">';
                echo '<button class="buy-button" ' . $buyButtonDisabled . '>Заказать</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>
