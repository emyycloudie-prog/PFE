<?php
// dashboard.php - لوحة التحكم الرئيسية مع الكلاسات
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$recent_clients = [];
$total_clients = 0;
$total_cases = 0;
$total_appointments = 0;

try {
    $stmt_clients = $db->query("SELECT COUNT(*) FROM clients");
    $total_clients = $stmt_clients->fetchColumn();

    $stmt_cases = $db->query("SELECT COUNT(*) FROM cases");
    $total_cases = $stmt_cases->fetchColumn();

    $stmt_appointments = $db->query("SELECT COUNT(*) FROM appointments");
    $total_appointments = $stmt_appointments->fetchColumn();

    $stmt_recent = $db->query("SELECT id_client, fullname, email, type FROM clients ORDER BY id_client DESC LIMIT 5");
    $recent_clients = $stmt_recent->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Error fetching dashboard stats: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Law Firm System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

    <!-- الهيدر أو البار العلوي للملاحة -->
    <header class="main-header">
        <div class="logo-area">
           <img src="img/white.png" alt="Law Firm Logo" class="site-logo">
            <h2>Law Firm System</h2>
            <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="dashboard.php" class="nav-link active">Dashboard</a></li>
                <li><a href="clients.php" class="nav-link">Manage Clients</a></li>
                <li><a href="casas.php" class="nav-link">Manage Cases</a></li>
                <li><a href="appointment.php" class="nav-link">Manage Appointments</a></li>
                <li><a href="logout.php" class="nav-link logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="content-container">
        <h1 class="page-title">Main Dashboard</h1>
        <p class="current-date">Today's Date: <?php echo date('Y-m-d'); ?></p>

        <?php if (isset($error_msg)): ?>
            <p class="error-message"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <!-- كروت الإحصائيات الدائرية أو المربعة -->
        <div class="stats-grid">
            <div class="stat-card card-clients">
                <h3>Total Clients</h3>
                <span class="stat-number"><?php echo $total_clients; ?></span>
            </div>
            <div class="stat-card card-cases">
                <h3>Law Cases</h3>
                <span class="stat-number"><?php echo $total_cases; ?></span>
            </div>
            <div class="stat-card card-appointments">
                <h3>Appointments</h3>
                <span class="stat-number"><?php echo $total_appointments; ?></span>
            </div>
        </div>

        <div class="table-section">
            <h2 class="section-title">Recently Registered Clients (Last 5)</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($recent_clients) > 0): ?>
                        <?php foreach ($recent_clients as $client): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($client['id_client']); ?></td>
                                <td><?php echo htmlspecialchars($client['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td><span class="badge badge-type"><?php echo htmlspecialchars($client['type']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">No clients found in the database yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>