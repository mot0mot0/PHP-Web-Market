<?php
require_once __DIR__ . '/../app/controllers/LoginController.php';
require_once __DIR__ . '/../app/controllers/SellerController.php';
require_once __DIR__ . '/../app/controllers/BuyerController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

session_start();
$auth = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? null;

if (preg_match('/\.(css|js|jpg|jpeg|png|gif)$/', $path)) {
    return false;
}

switch ($path) {
    case '/':
    case '/loginPage':
        LoginController::showLoginForm();
        break;

    case '/handleLogin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            LoginController::handleLogin($_POST['email'], $_POST['password']);
        } else {
            header('Location: /loginPage');
        }
        break;

    case '/logout':
        session_destroy();
        header('Location: /loginPage');
        break;

    case '/adminPage':
        if ($auth && $role === 'admin') {
            AdminController::showAdminForm();
        } else {
            header('Location: /loginPage');
        }
        break;

    case '/adminPage/addProduct':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::addProduct();
        } else {
            header('Location: /adminPage');
        }
        break;

    case '/ordersPage':
        if ($auth && ($role === 'seller' || $role === 'admin')) {
            SellerController::showOrdersForm();
        } else {
            header('Location: /loginPage');
        }
        break;

    case '/purchasePage':
        if ($auth && ($role === 'seller' || $role === 'admin')) {
            SellerController::showPurchaseForm();
        } else {
            header('Location: /loginPage');
        }
        break;

    case '/cataloguePage':
        if ($auth && ($role === 'buyer')) {
            $buyerController = new BuyerController();
            $buyerController->showCatalogueForm();
        } else {
            header('Location: /loginPage');
        }
        break;

    case '/cataloguePage/placeOrder':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $buyerController = new BuyerController();
            $buyerController->placeOrder();
        } else {
            header('Location: /cataloguePage');
        }
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
}
?>