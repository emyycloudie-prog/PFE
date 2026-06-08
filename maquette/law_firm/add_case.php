<?php
// add_case.php - إضافة قضية بالكلاسات
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
    $title = trim($_POST['title']);
    $case_number = trim($_POST['case_number']);
    $id_client = $_POST['id_client'];
    $court = trim($_POST['court']);
    $status = $_POST['status'];

    if (!empty($title) && !empty($id_client)) {
        try {
            $sql = "INSERT INTO cases (title, case_number, id_client, court, status) VALUES (:title, :case_number, :id_client, :court, :status)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':title'       => $title,
                ':case_number' => $case_number,
                ':id_client'   => $id_client,
                ':court'       => $court,
                ':status'      => $status
            ]);
            header("Location: casas.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error saving case to database: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in the required fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Add New Case</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

    <main class="form-container-box">
        <div class="form-box-header">
            <a href="casas.php" class="back-link">← Back to List</a>
            <h1>Add New Law Case</h1>
        </div>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="add_case.php" method="POST" class="crud-form">
            <div class="form-group">
                <label>Case Title / Name *</label>
                <input type="text" name="title" class="form-input" placeholder="e.g., Real Estate Dispute" required>
            </div>
            <div class="form-group">
                <label>Case Number (Numéro de dossier)</label>
                <input type="text" name="case_number" class="form-input">
            </div>
            <div class="form-group">
                <label>Select Client *</label>
                <select name="id_client" class="form-select" required>
                    <option value="">-- Choose a Client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id_client']; ?>"><?php echo htmlspecialchars($client['fullname']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Court (Tribunal)</label>
                <input type="text" name="court" class="form-input">
            </div>
            <div class="form-group">
                <label>Case Status</label>
                <select name="status" class="form-select">
                    <option value="Ongoing">Ongoing</option>
                    <option value="Closed">Closed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Save Case</button>
        </form>
    </main>

</body>
</html>