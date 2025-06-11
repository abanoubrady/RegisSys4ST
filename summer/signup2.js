function registerUser(event) {
    event.preventDefault(); // منع إعادة تحميل الصفحة

    let formData = new FormData(document.getElementById("registerForm"));
    let emailField = document.getElementById("email");
    let emailError = document.getElementById("emailError");

    // إعادة تعيين الحقل عند كل محاولة جديدة
    emailField.classList.remove("error");
    emailError.textContent = "";

    fetch("register.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // تحويل الاستجابة إلى JSON
    .then(data => {
        if (data.status === "error") {
            // إذا كان البريد الإلكتروني مسجلاً مسبقًا
            emailField.classList.add("error");
            emailError.textContent = data.message; // عرض الرسالة تحت الحقل
        } else {
            // إذا كان التسجيل ناجحًا، إعادة تعيين الحقول وعرض رسالة نجاح
            document.getElementById("registerForm").reset();
            alert(data.message); // عرض رسالة نجاح في نافذة منبثقة
        }
    })
    .catch(error => console.error("خطأ في الاتصال:", error));
}
