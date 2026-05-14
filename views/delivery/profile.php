<h1>My Profile</h1>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="profile-grid">
    <div class="card">
        <h2>Profile Picture</h2>
        <div class="profile-pic-container">
            <?php if ($user['profile_pic']): ?>
                <img src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile" class="profile-pic">
            <?php else: ?>
                <div class="profile-pic-placeholder"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
            <?php endif; ?>
        </div>
        <form method="POST" action="index.php?page=profile" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload_pic">
            <div class="form-group">
                <input type="file" name="profile_pic" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <div class="card">
        <h2>Update Information</h2>
        <form method="POST" action="index.php?page=profile" id="profileForm">
            <input type="hidden" name="action" value="update_profile">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($user['name']) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <div class="card">
        <h2>Change Password</h2>
        <form method="POST" action="index.php?page=profile" id="passwordForm">
            <input type="hidden" name="action" value="change_password">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required minlength="6">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

<script>
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    var newPass = document.getElementById('new_password').value;
    var confirmPass = document.getElementById('confirm_password').value;
    if (newPass !== confirmPass) {
        e.preventDefault();
        alert('Passwords do not match.');
    }
    if (newPass.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters.');
    }
});
</script>
