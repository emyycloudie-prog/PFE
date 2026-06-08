<?php
// create_admin.php - ملف إنشاء حساب مسؤول النظام (Admin)

// 1. استدعاء ملف الاتصال بقاعدة البيانات الصحيح
require_once 'db.php';

// 2. تحديد معلومات حساب الأدمن
$email = 'admin@lawfirm.com';
$plain_password = 'password123'; // هادا هو الباسورد العادي اللي غادي تدخلي بيه

// 3. تشفير الباسورد باستعمال خوارزمية BCRYPT القوية لحماية الحساب ف قاعدة البيانات
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
$fullname = 'System Administrator';

try {
    // 4. إدخال البيانات بأمان لجدول users باستخدام PDO البارامترات المجهزة
    $sql = "INSERT INTO users (email, password, fullname) VALUES (:email, :password, :fullname)";
    
    // استعمال المتغير $db الصحيح والمطابق لملف db.php ديالك
    $stmt = $db->prepare($sql);
    
    $stmt->execute([
        ':email' => $email,
        ':password' => $hashed_password,
        ':fullname' => $fullname
    ]);
    
    // رسالة نجاح تظهر في المتصفح أو الـ Terminal
    echo "<h1>Admin created successfully with hashed password!</h1>";
    echo "<p>Email: admin@lawfirm.com</p>";
    echo "<p>Password: password123</p>";
    echo "<br><a href='index.php'>Go to Login Page</a>";

} catch (PDOException $e) {
    // في حالة إذا كان الحساب ديجا مسجل أو كاين خطأ في أسماء الأعمدة
    echo "<h2>Error: " . $e->getMessage() . "</h2>";
}
?>