<?php
$host = "localhost";
$user = "root"; // اسم المستخدم الخاص بقاعدة البيانات (تغييره إذا لزم الأمر)
$pass = ""; // كلمة المرور (اتركه فارغًا إذا كنت تستخدم XAMPP)
$dbname = "Users"; // اسم قاعدة البيانات

$conn = new mysqli($host, $user, $pass, $dbname);

// فحص الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
