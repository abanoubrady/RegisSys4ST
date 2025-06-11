<?php
$host = "localhost"; // عنوان السيرفر
$user = "root"; // اسم المستخدم في MySQL
$password = ""; // كلمة المرور (اتركها فارغة إذا كنت تستخدم XAMPP)
$database = "trainings_db"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($host, $user, $password, $database);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// ضبط الترميز لضمان دعم اللغة العربية
$conn->set_charset("utf8");
?>



