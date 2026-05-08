<?php
require_once __DIR__ . '/../models/DeliveryZone.php';

class ZoneController {
    public function index() {
        requireRole('delivery_manager');

        $model = new DeliveryZone();
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'create') {
                $zoneName = trim($_POST['zone_name'] ?? '');
                $deliveryFee = floatval($_POST['delivery_fee'] ?? 0);
                $estimatedDays = (int)($_POST['estimated_days'] ?? 0);

                if (empty($zoneName) || $deliveryFee <= 0 || $estimatedDays <= 0) {
                    $error = 'Please fill all fields properly';
                } else {
                    if ($model->create($zoneName, $deliveryFee, $estimatedDays)) {
                        $success = 'Zone created!';
                    } else {
                        $error = 'Could not add the zone.';
                    }
                }
            } elseif ($action === 'update') {
                $id = (int)($_POST['zone_id'] ?? 0);
                $zoneName = trim($_POST['zone_name'] ?? '');
                $deliveryFee = floatval($_POST['delivery_fee'] ?? 0);
                $estimatedDays = (int)($_POST['estimated_days'] ?? 0);

                if (empty($zoneName) || $deliveryFee <= 0 || $estimatedDays <= 0) {
                    $error = 'All fields are required with valid values.';
                } else {
                    if ($model->update($id, $zoneName, $deliveryFee, $estimatedDays)) {
                        $success = 'Zone updated!';
                    } else {
                        $error = 'Failed to update zone.';
                    }
                }
            } elseif ($action === 'delete') {
                $id = (int)($_POST['zone_id'] ?? 0);
                if ($model->delete($id)) {
                    $success = 'Zone deleted.';
                } else {
                    $error = 'Cannot delete this zone, it might be assigned to deliveries.';
                }
            }
        }

        $zones = $model->getAll();
        $editZone = null;
        if (isset($_GET['edit'])) {
            $editZone = $model->getById((int)$_GET['edit']);
        }

        $page = 'zones';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/zones.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
