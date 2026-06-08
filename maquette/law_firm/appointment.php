<?php
// appointment.php - إدارة المواعيد بالكلاسات
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$appointments = [];

try {
    $sql = "SELECT a.*, cl.fullname as client_name, cl.phone as client_phone FROM appointments a LEFT JOIN clients cl ON a.id_client = cl.id_client ORDER BY a.appointment_date ASC";
    $stmt = $db->query($sql);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Error fetching appointments: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments - Law Firm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

    <header class="main-header">
        <div class="logo-area"><h2>Law Firm System</h2></div>
        <nav class="main-nav">
            <ul>
                <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li><a href="clients.php" class="nav-link">Manage Clients</a></li>
                <li><a href="casas.php" class="nav-link">Manage Cases</a></li>
                <li><a href="appointment.php" class="nav-link active">Manage Appointments</a></li>
                <li><a href="logout.php" class="nav-link logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="content-container">
        <div class="page-action-header">
            <h1 class="page-title">Booked Appointments List</h1>
            <a href="add_appointment.php" class="btn-add btn-appointment">+ Book Appointment</a>
        </div>

        <?php if (isset($error_msg)): ?>
            <p class="error-message"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Appointment Date</th>
                    <th>Time</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $app): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($app['id_appointment']); ?></td>
                            <td class="text-bold"><?php echo htmlspecialchars($app['client_name'] ?? 'Unknown'); ?></td>
                            <td><?php echo htmlspecialchars($app['client_phone'] ?? 'N/A'); ?></td>
                            <td><mark class="date-highlight"><?php echo htmlspecialchars($app['appointment_date']); ?></mark></td>
                            <td><?php echo htmlspecialchars($app['appointment_time']); ?></td>
                            <td><?php echo htmlspecialchars($app['note'] ?? 'No notes'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">No appointments scheduled yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>