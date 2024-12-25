<?php
require_once __DIR__ . '/../controllers/SellerController.php';

$sellerController = new SellerController();

$orders = $sellerController->getOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список заказов</title>
    <link rel="stylesheet" href="/assets/styles/ordersPage.css">
    <link rel="stylesheet" href="/assets/styles/navbar.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <div class="orders-container">
        <h1 class="page-title">Список заказов</h1>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Email покупателя</th>
                    <th>Название товара</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['buyer']); ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
