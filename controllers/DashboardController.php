<?php
require_once __DIR__ . '/../models/DeliveryAssignment.php';
require_once __DIR__ . '/../models/DeliveryAgent.php';

class DashboardController {
    public function index() {
        requireRole('delivery_manager');

        $assignmentModel = new DeliveryAssignment();
        $agentModel = new DeliveryAgent();

        $pendingDispatch = $assignmentModel->getPendingDispatchCount();
        $activeDeliveries = $assignmentModel->getActiveDeliveriesCount();
        $deliveredToday = $assignmentModel->getDeliveredTodayCount();
        $agents = $agentModel->getAll();
        $totalAgents = count($agents);
        $activeAgents = count(array_filter($agents, fn($a) => $a['is_active']));

        $page = 'dashboard';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/dashboard.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
