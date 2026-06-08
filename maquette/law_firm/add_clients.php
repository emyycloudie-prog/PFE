<?php
// add_clients.php - إضافة عميل جديد
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $id_card = trim($_POST['id_card']);
    $type = $_POST['type'];

    if (!empty($fullname) && !empty($phone)) {
        try {
            $sql = "INSERT INTO clients (fullname, phone, email, id_card, type) VALUES (:fullname, :phone, :email, :id_card, :type)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':fullname' => $fullname,
                ':phone'    => $phone,
                ':email'    => $email,
                ':id_card'  => $id_card,
                ':type'     => $type
            ]);
            
            // تحويل المستخدم لصفحة لائحة العملاء بعد النجاح
            header("Location: clients.php");
            exit();

        } catch (PDOException $e) {
            $error = "Error saving to database: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in the required fields (Name and Phone)!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Add New Client</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div>
        <h2><a href="clients.php">← Back to Clients List</a></h2>
        <h1>Add New Client to the System</h1>

        <?php if (!empty($error)): ?>
            <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="add_clients.php" method="POST">
            <div>
                <label>Client Full Name:</label><br>
                <input type="text" name="fullname" required>
            </div>
            <br>
            <div>
                <label>Phone Number:</label><br>
                <input type="text" name="phone" required>
            </div>
            <br>
            <div>
                <label>Email Address:</label><br>
                <input type="email" name="email">
            </div>
            <br>
            <div>
                <label>National ID Card (CIN):</label><br>
                <input type="text" name="id_card">
            </div>
            <br>
            <div>
                <label>Client Status / Role:</label><br>
                <select name="type">
                    <option value="طالب">Client (طالب)</option>
                    <option value="مطلوب ضده">Adverse (مطلوب ضده)</option>
                </select>
            </div>
            <br>
            <button type="submit" style="padding: 10px 20px; background-color: blue; color: white; cursor: pointer;">Save Client</button>
        </form>
    </div>

</body>
</html>