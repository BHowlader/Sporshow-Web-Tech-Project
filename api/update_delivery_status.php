<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isLoggedIn() || $_SESSION['user_role'] !== 'delivery_manager') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$assignmentId = isset($_POST['assignment_id']) ? (int)$_POST['assignment_id'] : 0;
$newStatus = isset($_POST['status']) ? trim($_POST['status']) : '';

// only allow these status values
$validStatuses = ['picked_up', 'in_transit', 'delivered'];
if ($assignmentId <= 0 || !in_array($newStatus, $validStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$conn = getDBConnection();

$deliveredAt = ($newStatus === 'delivered') ? date('Y-m-d H:i:s') : null;

if ($deliveredAt) {
    $stmt = $conn->prepare("UPDATE delivery_assignments SET status = ?, delivered_at = ? WHERE id = ?");
    $stmt->bind_param("ssi", $newStatus, $deliveredAt, $assignmentId);
} else {
    $stmt = $conn->prepare("UPDATE delivery_assignments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $assignmentId);
}

if ($stmt->execute()) {
    if ($newStatus === 'delivered') {
        $stmtOrder = $conn->prepare("UPDATE orders SET status = 'delivered' WHERE id = (SELECT order_id FROM delivery_assignments WHERE id = ?)");
        $stmtOrder->bind_param("i", $assignmentId);
        $stmtOrder->execute();
        $stmtOrder->close();
    }

    $statusLabel = ucwords(str_replace('_', ' ', $newStatus));
    echo json_encode([
        'success' => true,
        'message' => 'Status updated to ' . $statusLabel,
        'new_status' => $newStatus,
        'status_label' => $statusLabel
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();