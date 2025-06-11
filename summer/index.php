<?php
// الاتصال بقاعدة البيانات
include 'db_config.php';

function getTrainingStatus($conn, $id) {
    $sql = "SELECT content FROM scraped_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['content'] : "❌ لا توجد بيانات";
}

$nti_status = getTrainingStatus($conn, 1);
$itida_status = getTrainingStatus($conn, 2);
$career209_status = getTrainingStatus($conn, 3);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>  Summer training opportunities</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<style>
</style>
<body style="background-color: #ebfaff; font-family: Arial, sans-serif;">

<div class="container mt-5">
    <h2 >Summer training opportunities  </h2>

    <div class="row">
        <!-- NTI -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <img src="nti.jpg" class="card-img-top" alt="NTI Training">
                <div class="card-body text-center">
                    <h4 class="card-title">National Telecommunication Institute <h4>(NTI)</h4> </h4>
                    <p class="card-text <?php echo ($nti_status == '✅  Registration is available') ? 'text-success' : 'text-danger'; ?>">
                        <?php echo $nti_status; ?>
                    </p>
                    <a href="https://www.nti.sci.eg/summertraining/closed.html" class="btn btn-primary" target="_blank">Website </a>
                </div>
            </div>
        </div>

        <!-- ITIDA -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <img src="itada.jpg" class="card-img-top" alt="ITIDA Training">
                <div class="card-body text-center">
                    <h4 class="card-title">Information Technology Industry Development Agency <h3>(ITIDA)</h3></h4><br>
                    <p class="card-text <?php echo ($itida_status == '✅ Registration is available') ? 'text-success' : 'text-danger'; ?>">
                        <?php echo $itida_status; ?>
                    </p>
                    <a href="https://itida.gov.eg/english/programs/studentsummertraining/pages/default.aspx" class="btn btn-primary" target="_blank">Website </a>
                </div>
            </div>
        </div>

        <!-- Career209 -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <img src="career.png" class="card-img-top" alt="Career209 Training">
                <div class="card-body text-center">
                    <h1 class="card-title">Career</h1><br><br><br>
                    <p class="card-text <?php echo ($career209_status == '✅  Registration is available') ? 'text-success' : 'text-danger'; ?>">
                        <?php echo $career209_status; ?>
                    </p>
                    <a href="https://www.career209.com/search/label/%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8%20%D8%A7%D9%84%D8%B5%D9%8A%D9%81%D9%8A" class="btn btn-primary" target="_blank">Website </a>
                </div>
            </div>
        </div>

    </div>
</div>
<button id="backToHome" class="btn btn-primary" > Home</button><br>
<script src="index.js"></script>


</body>
</html>
