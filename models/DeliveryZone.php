<?php
require_once __DIR__ . '/../config/database.php';

class DeliveryZone {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM delivery_zones ORDER BY zone_name");
        $zones = [];
        while ($row = $result->fetch_assoc()) {
            $zones[] = $row;
        }
        return $zones;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM delivery_zones WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $zone = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $zone;
    }

    public function create($zoneName, $deliveryFee, $estimatedDays) {
        $stmt = $this->conn->prepare("INSERT INTO delivery_zones (zone_name, delivery_fee, estimated_days) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $zoneName, $deliveryFee, $estimatedDays);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function update($id, $zoneName, $deliveryFee, $estimatedDays) {
        $stmt = $this->conn->prepare("UPDATE delivery_zones SET zone_name = ?, delivery_fee = ?, estimated_days = ? WHERE id = ?");
        $stmt->bind_param("sdii", $zoneName, $deliveryFee, $estimatedDays, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM delivery_zones WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {
        $this->conn->close();
    }
}
