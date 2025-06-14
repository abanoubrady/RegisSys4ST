<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_config.php';

function fetchHTML($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

function scrapeNTI() {
    $url = "https://www.nti.sci.eg/summertraining/register.php";
    $html = fetchHTML($url);

    if (!$html) {
        return "❌ تعذر الوصول إلى الموقع";
    }

    // ابحث عن الكلمات المفتاحية في الصفحة
    $keywords = ['register', 'sign in', 'create profile'];
    $htmlLower = strtolower($html); // تحويل المحتوى لحروف صغيرة لتسهيل البحث

    foreach ($keywords as $keyword) {
        if (strpos($htmlLower, $keyword) !== false) {
            return "✅  Registration is available";
        }
    }

    return "❌ Registration is not available";
}


function scrapeITIDA() {
    $url = "https://itida.gov.eg/english/programs/studentsummertraining/pages/default.aspx";
    $html = fetchHTML($url);

    if (!$html) {
        return "❌ تعذر الوصول إلى الموقع";
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new DOMXPath($dom);
    $registerButtons = $xpath->query("//*[contains(@class, 'contactUsButton')]");

    if ($registerButtons->length > 0) {
        foreach ($registerButtons as $button) {
            if (strpos($button->textContent, 'Register') !== false) {
                return "✅ Registration is available";
            }
        }
    }

    return "❌  Registration is not available ";
}

function scrapeCareer209() {
    $url = "https://www.career209.com/search/label/%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8%20%D8%B7%D9%84%D8%A7%D8%A8%20%D8%AD%D8%A7%D8%B3%D8%A8%D8%A7%D8%AA%20%D9%88%D9%85%D8%B9%D9%84%D9%88%D9%85%D8%A7%D8%AA";
    $html = fetchHTML($url);

    if (!$html) {
        return "❌ تعذر الوصول إلى الموقع";
    }

    if (strpos($html, 'تدريب طلاب') !== false) {
        return "✅  Registration is available";
    }

    return "❌ التسجيل غير متاح";
}

function updateDatabase($conn, $id, $content) {
    $sql = "INSERT INTO scraped_data (id, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id, $content, $content);
    $stmt->execute();
}

$nti_status = scrapeNTI();
$itida_status = scrapeITIDA();
$career209_status = scrapeCareer209();

updateDatabase($conn, 1, $nti_status);
updateDatabase($conn, 2, $itida_status);
updateDatabase($conn, 3, $career209_status);

$conn->close();

echo "✅ تم تحديث البيانات بنجاح!";
?>
