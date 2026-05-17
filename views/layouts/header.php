<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sporshow - Delivery Manager</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (isLoggedIn() && $_SESSION['user_role'] === 'delivery_manager'): ?>
<nav class="sidebar">
    <div class="sidebar-header">
        <h2>Sporshow</h2>
        <p>Delivery Manager</p>
    </div>
    <ul class="nav-links">
        <li><a href="index.php?page=dashboard" class="<?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="index.php?page=agents" class="<?= ($page ?? '') === 'agents' ? 'active' : '' ?>">Delivery Agents</a></li>
        <li><a href="index.php?page=zones" class="<?= ($page ?? '') === 'zones' ? 'active' : '' ?>">Delivery Zones</a></li>
        <li><a href="index.php?page=dispatch" class="<?= ($page ?? '') === 'dispatch' ? 'active' : '' ?>">Dispatch Orders</a></li>
        <li><a href="index.php?page=active" class="<?= ($page ?? '') === 'active' ? 'active' : '' ?>">Active Deliveries</a></li>
        <li><a href="index.php?page=profile" class="<?= ($page ?? '') === 'profile' ? 'active' : '' ?>">My Profile</a></li>
        <li><a href="index.php?page=logout">Logout</a></li>
    </ul>
</nav>
<main class="content">
<?php endif; ?>
