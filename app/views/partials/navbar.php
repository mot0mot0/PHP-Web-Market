<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;
?>
<nav class="navbar">
    <ul class="navbar-list">
        <ul class="navbar-base-items">
        <?php if ($role === 'admin'): ?>
            <li><a href="/adminPage" class="navbar-link">Номенклатура</a></li>
            <li><a href="/ordersPage" class="navbar-link">Заказы</a></li>
            <li><a href="/purchasePage" class="navbar-link">Закупки</a></li>
        <?php elseif ($role === 'seller'): ?>
            <li><a href="/ordersPage" class="navbar-link">Заказы</a></li>
            <li><a href="/purchasePage" class="navbar-link">Закупки</a></li>
        <?php elseif ($role === 'buyer'): ?>
            <li><a href="/cataloguePage" class="navbar-link">Каталог</a></li>
        <?php endif; ?>
        </ul>
        <li ><a href="/logout" class="navbar-link navbar-link-logout">Выйти</a></li>
    </ul>
</nav>
