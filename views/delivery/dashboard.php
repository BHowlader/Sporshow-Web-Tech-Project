<h1>Logistics Dashboard</h1>
<p>Welcome back, <?= htmlspecialchars(currentUserName()) ?>!</p>

<div class="stats-grid">
    <div class="stat-card stat-warning">
        <h3>Pending Dispatch</h3>
        <span class="stat-number"><?= $pendingDispatch ?></span>
        <p>Orders awaiting assignment</p>
    </div>
    <div class="stat-card stat-info">
        <h3>Active Deliveries</h3>
        <span class="stat-number"><?= $activeDeliveries ?></span>
        <p>Currently in progress</p>
    </div>
    <div class="stat-card stat-success">
        <h3>Delivered Today</h3>
        <span class="stat-number"><?= $deliveredToday ?></span>
        <p>Completed deliveries</p>
    </div>
    <div class="stat-card">
        <h3>Total Agents</h3>
        <span class="stat-number"><?= $totalAgents ?></span>
        <p><?= $activeAgents ?> active</p>
    </div>
</div>

<div class="quick-actions">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="index.php?page=dispatch" class="action-card">Dispatch Orders</a>
        <a href="index.php?page=active" class="action-card">View Active Deliveries</a>
        <a href="index.php?page=agents" class="action-card">Manage Agents</a>
        <a href="index.php?page=zones" class="action-card">Manage Zones</a>
    </div>
</div>
