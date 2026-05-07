<h1>Delivery Agents</h1>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <h2><?= $editAgent ? 'Edit Agent' : 'Add New Agent' ?></h2>
    <form method="POST" action="index.php?page=agents" id="agentForm">
        <input type="hidden" name="action" value="<?= $editAgent ? 'update' : 'create' ?>">
        <?php if ($editAgent): ?>
            <input type="hidden" name="agent_id" value="<?= $editAgent['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required
                       value="<?= htmlspecialchars($editAgent['name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" required
                       value="<?= htmlspecialchars($editAgent['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="vehicle_type">Vehicle Type</label>
                <select id="vehicle_type" name="vehicle_type" required>
                    <option value="">Select...</option>
                    <option value="Motorcycle" <?= ($editAgent['vehicle_type'] ?? '') === 'Motorcycle' ? 'selected' : '' ?>>Motorcycle</option>
                    <option value="Van" <?= ($editAgent['vehicle_type'] ?? '') === 'Van' ? 'selected' : '' ?>>Van</option>
                    <option value="Bicycle" <?= ($editAgent['vehicle_type'] ?? '') === 'Bicycle' ? 'selected' : '' ?>>Bicycle</option>
                    <option value="Car" <?= ($editAgent['vehicle_type'] ?? '') === 'Car' ? 'selected' : '' ?>>Car</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?= $editAgent ? 'Update Agent' : 'Add Agent' ?></button>
        <?php if ($editAgent): ?>
            <a href="index.php?page=agents" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>All Agents</h2>
    <?php if (empty($agents)): ?>
        <p>No agents found.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Vehicle</th>
                <th>Active Deliveries</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($agents as $agent): ?>
            <tr>
                <td><?= $agent['id'] ?></td>
                <td><?= htmlspecialchars($agent['name']) ?></td>
                <td><?= htmlspecialchars($agent['phone']) ?></td>
                <td><?= htmlspecialchars($agent['vehicle_type']) ?></td>
                <td><?= $agent['active_count'] ?></td>
                <td>
                    <span class="badge <?= $agent['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                        <?= $agent['is_active'] ? 'Active' : 'Inactive' ?>
                    </span>
                </td>
                <td class="actions">
                    <a href="index.php?page=agents&edit=<?= $agent['id'] ?>" class="btn btn-small btn-secondary">Edit</a>
                    <form method="POST" action="index.php?page=agents" style="display:inline;">
                        <input type="hidden" name="action" value="toggle">
                        <input type="hidden" name="agent_id" value="<?= $agent['id'] ?>">
                        <input type="hidden" name="is_active" value="<?= $agent['is_active'] ? 0 : 1 ?>">
                        <button type="submit" class="btn btn-small <?= $agent['is_active'] ? 'btn-danger' : 'btn-success' ?>">
                            <?= $agent['is_active'] ? 'Deactivate' : 'Activate' ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<script>
document.getElementById('agentForm').addEventListener('submit', function(e) {
    var name = document.getElementById('name').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var vehicle = document.getElementById('vehicle_type').value;
    if (!name || !phone || !vehicle) {
        e.preventDefault();
        alert('All fields are required.');
    }
});
</script>
