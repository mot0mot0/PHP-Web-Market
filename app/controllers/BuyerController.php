<?php
require_once __DIR__ . '/../model/PocketBase.php';

class BuyerController
{
    private $pocketBase;

    public function __construct()
    {
        $this->pocketBase = new PocketBase();
    }

    public function showCatalogueForm()
    {
        $products = $this->pocketBase->getRecord('products');
        $products = $this->pocketBase->getFilesURL($products);

        require_once __DIR__ . '/../views/cataloguePage.php';
    }

    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            $userId = $_SESSION['user_id'];
            
            $orderData = [
                'product' => $productId,
                'buyer' => $userId,
                'status' => 'processing'
            ];

            if ($this->pocketBase->addRecord('orders', $orderData)) {
                $_SESSION['success'] = 'Заказ успешно оформлен!';
                $this->decreaseProductCount($productId);
            } else {
                $_SESSION['error'] = 'Ошибка при оформлении заказа.';
            }

            header('Location: /cataloguePage');
            exit();
        }
    }

    public function decreaseProductCount($productId)
    {
        try {
            $product = $this->pocketBase->getRecord('products', $productId);
            $updatedCount = $product['count'] - 1;

            $this->pocketBase->updateRecord('products', $productId, ['count' => $updatedCount]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
