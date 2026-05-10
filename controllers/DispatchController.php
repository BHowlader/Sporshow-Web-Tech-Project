<?php
require_once __DIR__ . '/../models/DeliveryAssignment.php';
require_once __DIR__ . '/../models/DeliveryAgent.php';
require_once __DIR__ . '/../models/DeliveryZone.php';

class DispatchController {
    public function index() {
        requireRole('delivery_manager');

        $assignmentModel = new DeliveryAssignment();
        $agentModel = new DeliveryAgent();
        $zoneModel = new DeliveryZone();
        $success = '';
        $error = '';

        // handle form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int)($_POST['order_id'] ?? 0);
            $agentId = (int)($_POST['agent_id'] ?? 0);
            $zoneId = (int)($_POST['zone_id'] ?? 0);

            if ($orderId <= 0 || $agentId <= 0 || $zoneId <= 0) {
                $error = 'Please select an agent and a zone';
            } else {
                if ($assignmentModel->assignAgent($orderId, $agentId, $zoneId)) {
                    $success = 'Order #' . $orderId . ' has been assigned!';
                } else {
                    $error = 'Something went wrong, could not assign agent.';
                }
            }
        }

        $orders = $assignmentModel->getOrdersReadyForDispatch();
        $agents = $agentModel->getActive();
        $zones = $zoneModel->getAll();

        $page = 'dispatch';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/dispatch.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
