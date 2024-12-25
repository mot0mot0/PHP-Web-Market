<?php
require_once __DIR__ . '/../services/PocketBase.php';

class AdminController
{
    public static function showAdminForm()
    {
        require_once __DIR__ . '/../views/adminPage.php';
    }

    public static function addProduct()
    {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $picture = $_FILES['picture'] ?? null;
        $description = $_POST['description'] ?? '';

        if (empty($name) || empty($price) || empty($description) || empty($picture)) {
            $_SESSION['error'] = 'Все поля должны быть заполнены.';
            header('Location: /adminPage');
            exit();
        }

        try {
            $pocketBaseService = new PocketBase();

            $productData = [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'count' => 0,
            ];

            if ($picture && $picture['error'] === UPLOAD_ERR_OK) {
                $filePath = $picture['tmp_name'];
                $product = $pocketBaseService->addRecord('products', $productData, $filePath);
            }

            $_SESSION['success'] = 'Товар добавлен успешно.';
            header('Location: /adminPage/addProduct');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Ошибка при добавлении товара: ' . $e->getMessage();
            header('Location: /admin');
        }

        exit();
    }
}
?>