<h1>Active Deliveries</h1>

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
                    <span class="badge badge-info">
                        <?= ucwords(str_replace('_', ' ', $d['status'])) ?>
                    </span>
                </td>
                <td><?= date('M d, H:i', strtotime($d['assigned_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
