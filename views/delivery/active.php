<h1>Active Deliveries</h1>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <h2>In-Progress Deliveries</h2>
    <?php if (empty($deliveries)): ?>
        <p>No active deliveries.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Zone</th>
                <th>Agent</th>
                <th>Status</th>
                <th>Assigned</th>
                <th>Update Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($deliveries as $d): ?>
            <tr>
                <td>#<?= $d['order_id'] ?></td>
                <td><?= htmlspecialchars($d['customer_name']) ?></td>
                <td><?= htmlspecialchars($d['zone_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($d['agent_name']) ?></td>
                <td>
                    <span class="badge badge-info status-badge" id="status-<?= $d['id'] ?>">
                        <?= ucwords(str_replace('_', ' ', $d['status'])) ?>
                    </span>
                </td>
                <td><?= date('M d, H:i', strtotime($d['assigned_at'])) ?></td>
                <td>
                    <select class="status-select" data-id="<?= $d['id'] ?>" onchange="updateDeliveryStatus(this)">
                        <option value="">Change...</option>
                        <?php if ($d['status'] === 'assigned'): ?>
                            <option value="picked_up">Picked Up</option>
                        <?php endif; ?>
                        <?php if ($d['status'] === 'assigned' || $d['status'] === 'picked_up'): ?>
                            <option value="in_transit">In Transit</option>
                        <?php endif; ?>
                        <?php if ($d['status'] !== 'delivered'): ?>
                            <option value="delivered">Delivered</option>
                        <?php endif; ?>
                    </select>
                </td>
                <td>
                    <button class="btn btn-small btn-danger" onclick="showFailModal(<?= $d['id'] ?>, <?= $d['order_id'] ?>, '<?= $d['delivery_zone'] ?? 0 ?>')">
                        Mark Failed
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div id="failModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Mark Delivery as Failed</h3>
        <form method="POST" action="index.php?page=active">
            <input type="hidden" name="action" value="mark_failed">
            <input type="hidden" name="assignment_id" id="fail_assignment_id">
            <div class="form-group">
                <label for="fail_reason">Reason for Failure</label>
                <textarea name="fail_reason" id="fail_reason" required rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Confirm Failed</button>
            <button type="button" class="btn btn-secondary" onclick="closeFailModal()">Cancel</button>
        </form>

        <hr>
        <h4>Re-assign to Another Agent</h4>
        <form method="POST" action="index.php?page=active">
            <input type="hidden" name="action" value="reassign">
            <input type="hidden" name="order_id" id="reassign_order_id">
            <input type="hidden" name="zone_id" id="reassign_zone_id">
            <div class="form-group">
                <label for="reassign_agent">Select New Agent</label>
                <select name="agent_id" id="reassign_agent" required>
                    <option value="">Select agent...</option>
                    <?php foreach ($agents as $agent): ?>
                        <option value="<?= $agent['id'] ?>"><?= htmlspecialchars($agent['name']) ?> (<?= $agent['vehicle_type'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Re-assign</button>
        </form>
    </div>
</div>

<script>
function showFailModal(assignmentId, orderId, zoneId) {
    document.getElementById('fail_assignment_id').value = assignmentId;
    document.getElementById('reassign_order_id').value = orderId;
    document.getElementById('reassign_zone_id').value = zoneId;
    document.getElementById('failModal').style.display = 'flex';
}
function closeFailModal() {
    document.getElementById('failModal').style.display = 'none';
}
</script>
