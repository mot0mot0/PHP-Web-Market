<?php
require_once __DIR__ . '/../services/PocketBase.php';

class SellerController {
    private $pocketBase;

    public function __construct()
    {
        $this->pocketBase = new PocketBase();
    }

    public static function showOrdersForm() {
        require_once __DIR__ . '/../views/ordersPage.php';
    }

    public static function showPurchaseForm() {
        require_once __DIR__ . '/../views/purchasePage.php';
    }

    public function getProducts()
    {
        try {
            return $this->pocketBase->getRecord('products');
        } catch (Exception $e) {
            return [];
        }
    }

    public function increaseProductCount($productId)
    {
        try {
            $product = $this->pocketBase->getRecord('products', $productId);
            $updatedCount = $product['count'] + 1;

            $this->pocketBase->updateRecord('products', $productId, ['count' => $updatedCount]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getOrders()
    {
        $orders = $this->pocketBase->getRecord('orders');
        foreach ($orders as &$order) {
            $user = $this->pocketBase->getRecord('users', $order['buyer']);
            $product = $this->pocketBase->getRecord('products', $order['product']);

            $order['buyer'] = $user['email'] ?? 'Unknown';
            $order['product'] = $product['name'] ?? 'Unknown';
        }

        return $orders;
    }
}
?>
