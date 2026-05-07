<?php
require_once __DIR__ . '/../config/database.php';

class DeliveryAgent {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function getAll() {
        $sql = "SELECT da.*,
                (SELECT COUNT(*) FROM delivery_assignments ass WHERE ass.agent_id = da.id AND ass.status IN ('assigned','picked_up','in_transit')) as active_count
                FROM delivery_agents da ORDER BY da.created_at DESC";
        $result = $this->conn->query($sql);
        $agents = [];
        while ($row = $result->fetch_assoc()) {
            $agents[] = $row;
        }
        return $agents;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM delivery_agents WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $agent = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $agent;
    }

    public function getActive() {
        $sql = "SELECT da.*,
                (SELECT COUNT(*) FROM delivery_assignments ass WHERE ass.agent_id = da.id AND ass.status IN ('assigned','picked_up','in_transit')) as active_count
                FROM delivery_agents da WHERE da.is_active = 1 ORDER BY da.name";
        $result = $this->conn->query($sql);
        $agents = [];
        while ($row = $result->fetch_assoc()) {
            $agents[] = $row;
        }
        return $agents;
    }

    public function create($name, $phone, $vehicleType) {
        $stmt = $this->conn->prepare("INSERT INTO delivery_agents (name, phone, vehicle_type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $vehicleType);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function update($id, $name, $phone, $vehicleType) {
        $stmt = $this->conn->prepare("UPDATE delivery_agents SET name = ?, phone = ?, vehicle_type = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $phone, $vehicleType, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function toggleActive($id, $isActive) {
        $stmt = $this->conn->prepare("UPDATE delivery_agents SET is_active = ? WHERE id = ?");
        $stmt->bind_param("ii", $isActive, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {
        $this->conn->close();
    }
}
