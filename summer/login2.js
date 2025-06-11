function loginUser(event) {
    event.preventDefault(); // منع إعادة تحميل الصفحة
    
    let formData = new FormData(document.getElementById("loginForm"));
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let errorMessage = document.getElementById("errorMessage");

    // إعادة تعيين التنسيقات السابقة
    emailField.classList.remove("error");
    passwordField.classList.remove("error");
    errorMessage.textContent = "";

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            emailField.classList.add("error");
            passwordField.classList.add("error");
            errorMessage.textContent = data.message;
        } else {
            window.location.href = "index.php"; // تحويل المستخدم إلى الصفحة الرئيسية
        }
    })
    .catch(error => console.error("خطأ في الاتصال:", error));
}