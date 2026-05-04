<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, name, email, password_hash, role, is_active FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
            return $user;
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, role, profile_pic, is_active, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function updateProfile($id, $name, $phone) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $phone, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function updatePassword($id, $passwordHash) {
        $stmt = $this->conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $passwordHash, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function updateProfilePic($id, $picPath) {
        $stmt = $this->conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $picPath, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {
        $this->conn->close();
    }
}
