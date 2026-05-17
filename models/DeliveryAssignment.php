<?php
require_once __DIR__ . '/../config/database.php';

class DeliveryAssignment {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    // get orders that havent been assigned yet
    public function getOrdersReadyForDispatch() {
        $sql = "SELECT o.id, o.customer_id, o.shipping_address, o.total_amount, o.status, o.created_at,
                       u.name as customer_name
                FROM orders o
                JOIN users u ON o.customer_id = u.id
                WHERE o.status = 'shipped'
                AND o.id NOT IN (SELECT order_id FROM delivery_assignments WHERE status != 'failed')
                ORDER BY o.created_at ASC";
        $result = $this->conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function assignAgent($orderId, $agentId, $zoneId) {
        $stmt = $this->conn->prepare("INSERT INTO delivery_assignments (order_id, agent_id, delivery_zone) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $orderId, $agentId, $zoneId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getActiveDeliveries() {
        $sql = "SELECT da.*, o.shipping_address, o.total_amount, u.name as customer_name,
                       ag.name as agent_name, dz.zone_name
                FROM delivery_assignments da
                JOIN orders o ON da.order_id = o.id
                JOIN users u ON o.customer_id = u.id
                JOIN delivery_agents ag ON da.agent_id = ag.id
                LEFT JOIN delivery_zones dz ON da.delivery_zone = dz.id
                WHERE da.status IN ('assigned','picked_up','in_transit')
                ORDER BY da.assigned_at DESC";
        $result = $this->conn->query($sql);
        $deliveries = [];
        while ($row = $result->fetch_assoc()) {
            $deliveries[] = $row;
        }
        return $deliveries;
    }

    public function getPendingDispatchCount() {
        $sql = "SELECT COUNT(*) as cnt FROM orders WHERE status = 'shipped' AND id NOT IN (SELECT order_id FROM delivery_assignments WHERE status != 'failed')";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['cnt'];
    }

    public function getActiveDeliveriesCount() {
        $sql = "SELECT COUNT(*) as cnt FROM delivery_assignments WHERE status IN ('assigned','picked_up','in_transit')";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['cnt'];
    }

    public function getDeliveredTodayCount() {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM delivery_assignments WHERE status = 'delivered' AND DATE(delivered_at) = ?");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_assoc()['cnt'];
        $stmt->close();
        return $count;
    }

    public function __destruct() {
        $this->conn->close();
    }
}
