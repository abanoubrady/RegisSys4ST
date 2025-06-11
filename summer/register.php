<?php
include "db.php"; // الاتصال بقاعدة البيانات

header('Content-Type: application/json'); // تحديد نوع الاستجابة كـ JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $major = trim($_POST["major"]);
    $academic_background = trim($_POST["academic_background"]);
    $interests = trim($_POST["interests"]);

    // التحقق مما إذا كان البريد الإلكتروني مسجلاً مسبقًا
    $check_email = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "⚠ البريد الإلكتروني مسجل مسبقًا، الرجاء استخدام بريد آخر."]);
        exit();
    } else {
        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // إدراج المستخدم في قاعدة البيانات
        $sql = "INSERT INTO users (name, email, password, major, academic_background, interests) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $major, $academic_background, $interests);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "✅ تم التسجيل بنجاح!"]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "⚠ حدث خطأ أثناء التسجيل، حاول مرة أخرى."]);
            exit();
        }
    }

    $stmt->close();
}
?>
