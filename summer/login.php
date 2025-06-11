<?php
session_start();
include("db.php"); // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "يرجى ملء جميع الحقول"]);
        exit();
    }

    // البحث عن المستخدم في قاعدة البيانات
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // التحقق من كلمة المرور
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // تخزين بيانات المستخدم في الجلسة
            echo json_encode(["status" => "success", "message" => "تم تسجيل الدخول بنجاح"]);
        } else {
            echo json_encode(["status" => "error", "message" => "كلمة المرور غير صحيحة"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "البريد الإلكتروني غير موجود"]);
    }

    $stmt->close();
    $conn->close();
}
?>
