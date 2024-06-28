<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST['url'];
    $data = getWebsiteData($url);
    echo json_encode($data);
}

function getWebsiteData($url) {
    static $requestCount = 0;
    $requestCount++;
    $start = microtime(true);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $end = microtime(true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseTime = ($end - $start) * 1000; // Convert to milliseconds
    $time = time();
    $status = ($httpCode >= 200 && $httpCode < 400) ? 'up' : 'down';

    return ['requestCount' => $requestCount, 'responseTime' => $responseTime, 'time' => $time, 'status' => $status];
}
?>
