<?php
require_once __DIR__ . '/../models/DeliveryAgent.php';

class AgentController {
    public function index() {
        requireRole('delivery_manager');

        $agentModel = new DeliveryAgent();
        $success = '';
        $error = '';
        $model = $agentModel;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'create') {
                $name = trim($_POST['name'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $vehicleType = trim($_POST['vehicle_type'] ?? '');

                if (empty($name) || empty($phone) || empty($vehicleType)) {
                    $error = 'Please fill all the fields';
                } else {
                    if ($model->create($name, $phone, $vehicleType)) {
                        $success = 'Agent added!';
                    } else {
                        $error = 'Could not add agent, try again.';
                    }
                }
            } elseif ($action === 'update') {
                $id = (int)($_POST['agent_id'] ?? 0);
                $name = trim($_POST['name'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $vehicleType = trim($_POST['vehicle_type'] ?? '');

                if (empty($name) || empty($phone) || empty($vehicleType)) {
                    $error = 'All fields are required.';
                } else {
                    if ($model->update($id, $name, $phone, $vehicleType)) {
                        $success = 'Agent info updated';
                    } else {
                        $error = 'Update failed, please try again.';
                    }
                }
            } elseif ($action === 'toggle') {
                $id = (int)($_POST['agent_id'] ?? 0);
                $isActive = (int)($_POST['is_active'] ?? 0);
                if ($model->toggleActive($id, $isActive)) {
                    $success = $isActive ? 'Agent activated.' : 'Agent deactivated.';
                } else {
                    $error = 'Failed to update agent status.';
                }
            }
        }

        $agents = $model->getAll();
        $editAgent = null;
        if (isset($_GET['edit'])) {
            $editAgent = $model->getById((int)$_GET['edit']);
        }

        $page = 'agents';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/agents.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
