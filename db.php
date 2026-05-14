<?php
// 資料庫連線設定 - 優先使用Railway環境變數，本機開發時使用預設值
$url = getenv('DATABASE_URL') ?: "mysql://root:QMBBipAKqAvvSSFqsRAebVkqKEPYmZIg@yamanote.proxy.rlwy.net:13554/railway";

// 解析連線URL
$parts = parse_url($url);
$host = $parts['host'];
$port = isset($parts['port']) ? $parts['port'] : 3306;
$user = $parts['user'];
$pass = isset($parts['pass']) ? $parts['pass'] : '';
$dbname = ltrim($parts['path'], '/');

// 建立連線 - 增加錯誤處理避免致命錯誤
try {
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    // 檢查連線
    if ($conn->connect_error) {
        throw new Exception("資料庫連線失敗: " . $conn->connect_error);
    }

    // 設定編碼
    $conn->set_charset("utf8mb4");

    // 建立必要資料表
    // 使用者表 - 移除email唯一約束，添加恢復碼欄位
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        recovery_code VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_login TIMESTAMP NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 訪問計數表
    $conn->query("CREATE TABLE IF NOT EXISTS visitor_count (
        id INT AUTO_INCREMENT PRIMARY KEY,
        total_visits INT NOT NULL DEFAULT 0,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 初始化訪問計數
    $result = $conn->query("SELECT * FROM visitor_count");
    if ($result->num_rows == 0) {
        $conn->query("INSERT INTO visitor_count (total_visits) VALUES (0)");
    }

    // 增加訪問次數
    $conn->query("UPDATE visitor_count SET total_visits = total_visits + 1");

    // 取得總訪問人次
    function get_total_visits() {
        global $conn;
        $result = $conn->query("SELECT total_visits FROM visitor_count LIMIT 1");
        $row = $result->fetch_assoc();
        return $row['total_visits'];
    }

    // 關閉連線函數
    function close_db() {
        global $conn;
        $conn->close();
    }

} catch (Exception $e) {
    // 資料庫連線失敗時的優雅降級
    error_log("資料庫錯誤: " . $e->getMessage());
    
    // 定義空函數避免頁面出錯
    function get_total_visits() {
        return "暫無法統計";
    }
    
    function close_db() {
        // 空函數
    }
}
?>
