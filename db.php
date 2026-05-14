<?php
// 資料庫連線 - 自動判斷 本機(XAMPP) / 線上環境
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // 本地 XAMPP 開發環境：使用 Railway 外部連線資訊
    $host = 'localhost';
    $port = '18445';
    $user = 'root';
    $pwd  = ' ';
    $dbname = 'railway';
} else {
    // 線上環境（Railway / Vercel）：使用環境變數
    $host = getenv('MYSQLHOST');
    $port = getenv('MYSQLPORT');
    $user = getenv('MYSQLUSER');
    $pwd  = getenv('MYSQLPASSWORD');
    $dbname = getenv('MYSQLDATABASE');
}

// 建立資料庫連線
$conn = mysqli_connect('localhost', 'root', '', 'test', 3306);

// 檢查連線是否成功
if (!$conn) {
    die("資料庫連線失敗：" . mysqli_connect_error());
}

// 設定繁體中文編碼
mysqli_set_charset($conn, "utf8mb4");
?>