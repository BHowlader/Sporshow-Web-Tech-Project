<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController {
    public function index() {
        requireRole('delivery_manager');

        $model = new User();
        $user = $model->getById(currentUserId());
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update_profile') {
                $name = trim($_POST['name'] ?? '');
                $phone = trim($_POST['phone'] ?? '');

                if (empty($name)) {
                    $error = 'Name cannot be empty';
                } else {
                    if ($model->updateProfile(currentUserId(), $name, $phone)) {
                        $_SESSION['user_name'] = $name;
                        $success = 'Profile updated!';
                        $user = $model->getById(currentUserId());
                    } else {
                        $error = 'Could not update profile.';
                    }
                }
            } elseif ($action === 'change_password') {
                $currentPass = $_POST['current_password'] ?? '';
                $newPass = $_POST['new_password'] ?? '';
                $confirmPass = $_POST['confirm_password'] ?? '';

                if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
                    $error = 'Fill in all password fields';
                } elseif ($newPass !== $confirmPass) {
                    $error = 'Passwords dont match';
                } elseif (strlen($newPass) < 6) {
                    $error = 'Password too short, minimum 6 characters';
                } else {
                    $checkUser = $model->getById(currentUserId());
                    $connCheck = getDBConnection();
                    $stmt = $connCheck->prepare("SELECT password_hash FROM users WHERE id = ?");
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $hash = $stmt->get_result()->fetch_assoc()['password_hash'];
                    $stmt->close();
                    $connCheck->close();

                    if (!password_verify($currentPass, $hash)) {
                        $error = 'Current password is wrong';
                    } else {
                        $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                        if ($model->updatePassword(currentUserId(), $newHash)) {
                            $success = 'Password changed!';
                        } else {
                            $error = 'Could not change password.';
                        }
                    }
                }
            } elseif ($action === 'upload_pic') {
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/profiles/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array(strtolower($ext), $allowed)) {
                        $error = 'Only jpg, png or gif allowed';
                    } else {
                        $filename = 'profile_' . currentUserId() . '_' . time() . '.' . $ext;
                        $filepath = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filepath)) {
                            $model->updateProfilePic(currentUserId(), $filepath);
                            $success = 'Profile picture updated.';
                            $user = $model->getById(currentUserId());
                        } else {
                            $error = 'Failed to upload file.';
                        }
                    }
                } else {
                    $error = 'Please select a file to upload.';
                }
            }
        }

        $page = 'profile';
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/delivery/profile.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
