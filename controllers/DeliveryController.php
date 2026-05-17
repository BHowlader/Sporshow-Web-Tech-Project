<?php
require_once __DIR__ . '/../models/DeliveryAssignment.php';

class DeliveryController {
    public function active() {
        requireRole('delivery_manager');

        $model = new DeliveryAssignment();
        $deliveries = $model->getActiveDeliveries();

        $page = 'active';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/active.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
