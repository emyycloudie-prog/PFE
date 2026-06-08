<?php
// logout.php - إنهاء الجلسة وتسجيل الخروج
session_start();

// مسح جميع متغيرات الجلسة
$_SESSION = array();

// تدمير الجلسة بالكامل
session_destroy();

// توجيه المستخدم لصفحة تسجيل الدخول
header("Location: index.php");
exit();
?>