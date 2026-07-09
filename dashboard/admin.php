<?php
include "headerPart.php";

// Get counts from database
$itemsCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM items"));
$categoryCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM category"));
$serviceCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM service"));
$visitorData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_visitors FROM site_visitors"));
$totalVisitors = $visitorData['total_visitors'];
?>

<style>
    .dashboard-header {
        padding: 20px 0;
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .dashboard-header h2 {
        margin: 0;
        font-weight: 300;
        color: #333;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        border-top: 4px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-card.categories {
        border-color: #4285F4;
    }

    .stat-card.items {
        border-color: #34A853;
    }

    .stat-card.services {
        border-color: #FBBC05;
    }

    .stat-card.visitors {
        border-color: #EA4335;
    }

    .stat-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .stat-icon.categories {
        color: #4285F4;
    }

    .stat-icon.items {
        color: #34A853;
    }

    .stat-icon.services {
        color: #FBBC05;
    }

    .stat-icon.visitors {
        color: #EA4335;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 300;
        margin: 10px 0;
        color: #333;
    }

    .stat-label {
        font-size: 16px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-header">
    <h2>Admin Dashboard</h2>
    <p>Welcome back! Here's what's happening with your site today.</p>
</div>

<div class="stats-container">
    <!-- Categories Card -->
    <div class="stat-card categories">
        <i class="fas fa-list stat-icon categories"></i>
        <div class="stat-value"><?= number_format($categoryCount) ?></div>
        <div class="stat-label">Categories</div>
    </div>

    <!-- Items Card -->
    <div class="stat-card items">
        <i class="fas fa-book stat-icon items"></i>
        <div class="stat-value"><?= number_format($itemsCount) ?></div>
        <div class="stat-label">Items</div>
    </div>

    <!-- Services Card -->
    <div class="stat-card services">
        <i class="fas fa-cogs stat-icon services"></i>
        <div class="stat-value"><?= number_format($serviceCount) ?></div>
        <div class="stat-label">Services</div>
    </div>

    <!-- Visitors Card -->
    <div class="stat-card visitors">
        <i class="fas fa-users stat-icon visitors"></i>
        <div class="stat-value"><?= number_format($totalVisitors) ?></div>
        <div class="stat-label">Visitors</div>
    </div>
</div>

<?php
include "footerPart.php";
?>