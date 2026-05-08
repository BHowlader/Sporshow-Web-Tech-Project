<h1>Delivery Zones</h1>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <h2><?= $editZone ? 'Edit Zone' : 'Add New Zone' ?></h2>
    <form method="POST" action="index.php?page=zones" id="zoneForm">
        <input type="hidden" name="action" value="<?= $editZone ? 'update' : 'create' ?>">
        <?php if ($editZone): ?>
            <input type="hidden" name="zone_id" value="<?= $editZone['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="zone_name">Zone Name</label>
                <input type="text" id="zone_name" name="zone_name" required
                       value="<?= htmlspecialchars($editZone['zone_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="delivery_fee">Delivery Fee (BDT)</label>
                <input type="number" id="delivery_fee" name="delivery_fee" step="0.01" min="0.01" required
                       value="<?= htmlspecialchars($editZone['delivery_fee'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="estimated_days">Estimated Days</label>
                <input type="number" id="estimated_days" name="estimated_days" min="1" required
                       value="<?= htmlspecialchars($editZone['estimated_days'] ?? '') ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?= $editZone ? 'Update Zone' : 'Add Zone' ?></button>
        <?php if ($editZone): ?>
            <a href="index.php?page=zones" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>All Zones</h2>
    <?php if (empty($zones)): ?>
        <p>No zones found.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Zone Name</th>
                <th>Delivery Fee (BDT)</th>
                <th>Estimated Days</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($zones as $zone): ?>
            <tr>
                <td><?= $zone['id'] ?></td>
                <td><?= htmlspecialchars($zone['zone_name']) ?></td>
                <td><?= number_format($zone['delivery_fee'], 2) ?></td>
                <td><?= $zone['estimated_days'] ?></td>
                <td class="actions">
                    <a href="index.php?page=zones&edit=<?= $zone['id'] ?>" class="btn btn-small btn-secondary">Edit</a>
                    <form method="POST" action="index.php?page=zones" style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this zone?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="zone_id" value="<?= $zone['id'] ?>">
                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<script>
document.getElementById('zoneForm').addEventListener('submit', function(e) {
    var name = document.getElementById('zone_name').value.trim();
    var fee = parseFloat(document.getElementById('delivery_fee').value);
    var days = parseInt(document.getElementById('estimated_days').value);
    if (!name || isNaN(fee) || fee <= 0 || isNaN(days) || days <= 0) {
        e.preventDefault();
        alert('Please fill in all fields with valid values.');
    }
});
</script>
