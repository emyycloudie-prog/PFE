<?php
// clients.php - عرض العملاء
session_start();
require_once 'db.php';

// حماية الصفحة
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$clients = [];

try {
    // جلب جميع العملاء من قاعدة البيانات مرتبين من الأحدث للأقدم
    $stmt = $db->query("SELECT id_client, fullname, phone, email, id_card, type FROM clients ORDER BY id_client DESC");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Error fetching clients data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Manage Clients - Law Firm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div>
        <h2>Law Firm System</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="clients.php">Manage Clients</a></li>
            <li><a href="casas.php">Manage Cases</a></li>
            <li><a href="appointment.php">Manage Appointments</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <hr>

    <div>
        <h1>Registered Clients List</h1>
        
        <a href="add_clients.php"><button style="padding: 10px; background-color: green; color: white; cursor: pointer;">+ Add New Client</button></a>
        <br><br>

        <?php if (isset($error_msg)): ?>
            <p style="color: red;"><?php echo $error_msg; ?></p>
        <?php endif; ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email Address</th>
                    <th>National ID (CIN)</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($clients) > 0): ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($client['id_client']); ?></td>
                            <td><?php echo htmlspecialchars($client['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($client['phone']); ?></td>
                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                            <td><?php echo htmlspecialchars($client['id_card']); ?></td>
                            <td><?php echo htmlspecialchars($client['type']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No clients registered yet. Click on Add New Client.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>