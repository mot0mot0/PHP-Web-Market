<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="/assets/styles/adminPage.css">
    <link rel="stylesheet" href="/assets/styles/navbar.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <div class="admin-container">
        <h1 class="page-title">Добавление товара</h1>
        
        <div class="orders-adding-card">
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

            <form action="/adminPage/addProduct" method="POST" enctype="multipart/form-data" class="admin-form">
                <label for="name">Название товара</label>
                <input type="text" name="name" required><br>

                <label for="price">Цена</label>
                <input type="number" name="price" required><br>

                <label for="description">Описание</label>
                <textarea name="description" required></textarea><br>

                <label for="picture">Изображение товара</label>
                <input type="file" name="picture" required><br>

                <button type="submit" class="button">Загрузить</button>
            </form>
        </div>
    </div>
</body>
</html>
