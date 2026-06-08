<?php
// add_appointment.php - إضافة موعد بالكلاسات
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$clients = [];

try {
    $stmt_clients = $db->query("SELECT id_client, fullname FROM clients ORDER BY fullname ASC");
    $clients = $stmt_clients->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error loading clients: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_POST['id_client'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $note = trim($_POST['note']);

    if (!empty($id_client) && !empty($appointment_date) && !empty($appointment_time)) {
        try {
            $sql = "INSERT INTO appointments (id_client, appointment_date, appointment_time, note) VALUES (:id_client, :appointment_date, :appointment_time, :note)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':id_client'        => $id_client,
                ':appointment_date' => $appointment_date,
                ':appointment_time' => $appointment_time,
                ':note'             => $note
            ]);
            header("Location: appointment.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error booking appointment: " . $e->getMessage();
        }
    } else {
        $error = "All fields except notes are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

    <main class="form-container-box">
        <div class="form-box-header">
            <a href="appointment.php" class="back-link">← Back to List</a>
            <h1>Book a New Appointment</h1>
        </div>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="add_appointment.php" method="POST" class="crud-form">
            <div class="form-group">
                <label>Select Client *</label>
                <select name="id_client" class="form-select" required>
                    <option value="">-- Select Client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id_client']; ?>"><?php echo htmlspecialchars($client['fullname']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Appointment Date *</label>
                <input type="date" name="appointment_date" class="form-input" required>
            </div>
            <div class="form-group">
                <label>Appointment Time *</label>
                <input type="time" name="appointment_time" class="form-input" required>
            </div>
            <div class="form-group">
                <label>Notes / Purpose</label>
                <textarea name="note" class="form-textarea" rows="4" placeholder="Reason for the meeting..."></textarea>
            </div>
            <button type="submit" class="btn-save btn-book">Book Appointment</button>
        </form>
    </main>

</body>
</html>