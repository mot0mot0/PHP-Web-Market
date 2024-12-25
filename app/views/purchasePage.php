<?php
require_once __DIR__ . '/../controllers/SellerController.php';

$sellerController = new SellerController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    if ($sellerController->increaseProductCount($productId)) { 
        echo "<script>alert('Количество товара увеличено!');</script>";
    } else {
        echo "<script>alert('Ошибка при увеличении количества товара.');</script>";
    }
}

$products = $sellerController->getProducts();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
    <link rel="stylesheet" href="/assets/styles/purchasePage.css">
    <link rel="stylesheet" href="/assets/styles/navbar.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <div class="purchase-container">
        <h1 class="page-title">Список товаров</h1>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Количество в наличии</th>
                    <th>Количество заказов</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?> руб.</td>
                        <td><?php echo htmlspecialchars($product['count']); ?></td>
                        <td><?php echo htmlspecialchars($product['orders'] ?? 0); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <button type="submit" class="button">Добавить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
