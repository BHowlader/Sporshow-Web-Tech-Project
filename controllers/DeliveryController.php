<?php
require_once __DIR__ . '/../models/DeliveryAssignment.php';
require_once __DIR__ . '/../models/DeliveryAgent.php';

class DeliveryController {
    public function active() {
        requireRole('delivery_manager');

        $model = new DeliveryAssignment();
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_failed') {
            $id = (int)($_POST['assignment_id'] ?? 0);
            $reason = trim($_POST['fail_reason'] ?? '');

            if (empty($reason)) {
                $error = 'You need to give a reason for the failure';
            } else {
                if ($model->markFailed($id, $reason)) {
                    $success = 'Marked as failed.';
                } else {
                    $error = 'Could not update, try again.';
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reassign') {
            $orderId = (int)($_POST['order_id'] ?? 0);
            $agentId = (int)($_POST['agent_id'] ?? 0);
            $zoneId = (int)($_POST['zone_id'] ?? 0);

            if ($orderId > 0 && $agentId > 0) {
                if ($model->assignAgent($orderId, $agentId, $zoneId)) {
                    $success = 'Reassigned to new agent';
                } else {
                    $error = 'Reassignment failed.';
                }
            }
        }

        $deliveries = $model->getActiveDeliveries();
        $agentModel = new DeliveryAgent();
        $agents = $agentModel->getActive();

        $page = 'active';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/active.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function history() {
        requireRole('delivery_manager');

        $model = new DeliveryAssignment();
        $deliveries = $model->getDeliveryHistory();

        $page = 'history';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/history.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function summary() {
        requireRole('delivery_manager');

        $model = new DeliveryAssignment();
        $dailyStats = $model->getSummaryStats('daily');
        $weeklyStats = $model->getSummaryStats('weekly');

        $page = 'summary';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/summary.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
