<?php

require_once __DIR__ . '/../services/PocketBase.php';

class LoginController {
    public static function showLoginForm() {
        require_once __DIR__ . '/../views/loginPage.php';
    }

    public static function handleLogin($email, $password) {
        try {
            $pocketBase = new PocketBase();
            $auth = $pocketBase->authWithPassword($email, $password);

            $_SESSION['user_id'] = $auth['record']['id'];
            $_SESSION['role'] = $auth['record']['role'];
            $_SESSION['token'] = $auth['token'];

            switch ($_SESSION['role']) {
                case 'seller':
                    header('Location: /ordersPage');
                    break;
                case 'buyer':
                    header('Location: /cataloguePage');
                    break;
                case 'admin':
                    header('Location: /adminPage');
                    break;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Неверные данные входа.";
            header('Location: /loginPage');
        }
    }
}
?>