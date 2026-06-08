<?php
// casas.php - عرض وإدارة القضايا بالكلاسات
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$cases = [];

try {
    $sql = "SELECT c.*, cl.fullname as client_name FROM cases c LEFT JOIN clients cl ON c.id_client = cl.id_client ORDER BY c.id_case DESC";
    $stmt = $db->query($sql);
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Error fetching cases data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Manage Cases - Law Firm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

    <header class="main-header">
        <div class="logo-area"><h2>Law Firm System</h2></div>
        <nav class="main-nav">
            <ul>
                <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li><a href="clients.php" class="nav-link">Manage Clients</a></li>
                <li><a href="casas.php" class="nav-link active">Manage Cases</a></li>
                <li><a href="appointment.php" class="nav-link">Manage Appointments</a></li>
                <li><a href="logout.php" class="nav-link logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="content-container">
        <div class="page-action-header">
            <h1 class="page-title">Law Cases List</h1>
            <a href="add_case.php" class="btn-add btn-case">+ Add New Case</a>
        </div>

        <?php if (isset($error_msg)): ?>
            <p class="error-message"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Case ID</th>
                    <th>Case Title</th>
                    <th>Case Number</th>
                    <th>Client Name</th>
                    <th>Court</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($cases) > 0): ?>
                    <?php foreach ($cases as $case): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($case['id_case']); ?></td>
                            <td class="text-bold"><?php echo htmlspecialchars($case['case_title']); ?></td>
                            <td><?php echo htmlspecialchars($case['case_number'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($case['client_name'] ?? 'Unknown'); ?></td>
                            <td><?php echo htmlspecialchars($case['court'] ?? 'N/A'); ?></td>
                            <td><span class="badge status-<?php echo strtolower($case['status']); ?>"><?php echo htmlspecialchars($case['status']); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">No law cases found. Click on Add New Case.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>