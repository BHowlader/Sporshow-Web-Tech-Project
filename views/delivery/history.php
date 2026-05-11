<h1>Delivery History</h1>

<div class="card">
    <h2>Completed &amp; Failed Deliveries</h2>
    <?php if (empty($deliveries)): ?>
        <p>No delivery history found.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Zone</th>
                <th>Agent</th>
                <th>Status</th>
                <th>Assigned At</th>
                <th>Completed At</th>
                <th>Fail Reason</th>
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
                    <span class="badge <?= $d['status'] === 'delivered' ? 'badge-success' : 'badge-danger' ?>">
                        <?= ucfirst($d['status']) ?>
                    </span>
                </td>
                <td><?= date('M d, Y H:i', strtotime($d['assigned_at'])) ?></td>
                <td><?= $d['delivered_at'] ? date('M d, Y H:i', strtotime($d['delivered_at'])) : '-' ?></td>
                <td><?= htmlspecialchars($d['fail_reason'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
