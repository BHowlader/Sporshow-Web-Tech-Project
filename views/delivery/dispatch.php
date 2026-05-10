<h1>Dispatch Orders</h1>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <h2>Orders Ready for Dispatch</h2>
    <?php if (empty($orders)): ?>
        <p>No orders pending dispatch.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Shipping Address</th>
                <th>Total (BDT)</th>
                <th>Order Date</th>
                <th>Assign</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                <td><?= number_format($order['total_amount'], 2) ?></td>
                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                <td>
                    <form method="POST" action="index.php?page=dispatch" class="dispatch-form">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="agent_id" required>
                            <option value="">Agent...</option>
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent['id'] ?>">
                                    <?= htmlspecialchars($agent['name']) ?> (<?= $agent['vehicle_type'] ?>) - <?= $agent['active_count'] ?> active
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="zone_id" required>
                            <option value="">Zone...</option>
                            <?php foreach ($zones as $zone): ?>
                                <option value="<?= $zone['id'] ?>">
                                    <?= htmlspecialchars($zone['zone_name']) ?> (<?= $zone['estimated_days'] ?> days)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-small btn-primary">Assign</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
