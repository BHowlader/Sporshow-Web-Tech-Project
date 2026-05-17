<?php
require_once __DIR__ . '/config/auth.php';

$page = $_GET['page'] ?? 'login';

if ($page === 'login' && isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit;
}

switch ($page) {
    case 'login':
        require_once __DIR__ . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'agents':
        require_once __DIR__ . '/controllers/AgentController.php';
        $controller = new AgentController();
        $controller->index();
        break;

    case 'zones':
        require_once __DIR__ . '/controllers/ZoneController.php';
        $controller = new ZoneController();
        $controller->index();
        break;

    case 'dispatch':
        require_once __DIR__ . '/controllers/DispatchController.php';
        $controller = new DispatchController();
        $controller->index();
        break;

    case 'active':
        require_once __DIR__ . '/controllers/DeliveryController.php';
        $controller = new DeliveryController();
        $controller->active();
        break;


    case 'profile':
        require_once __DIR__ . '/controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    default:
        header('Location: index.php?page=login');
        break;
}
