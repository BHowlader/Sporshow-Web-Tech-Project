<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $userModel = new User();
                $user = $userModel->login($email, $password);

                if ($user) {
                    if ($user['role'] !== 'delivery_manager') {
                        $error = 'Sorry, only delivery managers can login here.';
                    } else {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['role'];
                        header('Location: index.php?page=dashboard');
                        exit;
                    }
                } else {
                    $error = 'Wrong email or password';
                }
            }
        }
        require __DIR__ . '/../views/delivery/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
