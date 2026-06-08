<?php
// index.php - صفحة تسجيل الدخول المصححة مع الكلاسات
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = reset($user); 
                $_SESSION['user_name'] = $user['fullname'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } catch (PDOException $e) {
            $error = "System Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Law Firm Management System</title>
    <!-- ربط ملف الستايل الموحد -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <h2 class="login-title">Law Firm</h2>
        <p class="login-subtitle">Law Firm Management System</p>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST" class="login-form">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" placeholder="admin@lawfirm.com" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="***********" required>
            </div>
            
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>

</body>
</html>