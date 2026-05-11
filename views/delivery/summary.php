<h1>Delivery Summary</h1>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Today's Summary</h3>
        <div class="summary-row">
            <span>Delivered:</span>
            <strong><?= $dailyStats['total_delivered'] ?? 0 ?></strong>
        </div>
        <div class="summary-row">
            <span>Failed:</span>
            <strong><?= $dailyStats['total_failed'] ?? 0 ?></strong>
        </div>
        <div class="summary-row">
            <span>In Transit:</span>
            <strong><?= $dailyStats['total_in_transit'] ?? 0 ?></strong>
        </div>
    </div>
    <div class="stat-card">
        <h3>This Week's Summary</h3>
        <div class="summary-row">
            <span>Delivered:</span>
            <strong><?= $weeklyStats['total_delivered'] ?? 0 ?></strong>
        </div>
        <div class="summary-row">
            <span>Failed:</span>
            <strong><?= $weeklyStats['total_failed'] ?? 0 ?></strong>
        </div>
        <div class="summary-row">
            <span>In Transit:</span>
            <strong><?= $weeklyStats['total_in_transit'] ?? 0 ?></strong>
        </div>
    </div>
</div>
