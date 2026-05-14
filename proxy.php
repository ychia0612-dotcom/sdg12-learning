<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['debug' => '只接受 POST 請求']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['messages']) || !is_array($input['messages'])) {
    http_response_code(400);
    echo json_encode(['debug' => '請求格式錯誤']);
    exit;
}

// 從 Railway 環境變數讀取 API Key
$apiKey = getenv("OPENAI_API_KEY");
if (empty($apiKey)) {
    http_response_code(500);
    echo json_encode(['debug' => 'Railway 上未設定 OPENAI_API_KEY 環境變數']);
    exit;
}

// 呼叫 OpenAI API
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model" => "gpt-3.5-turbo",
    "messages" => $input['messages'],
    "temperature" => 0.7
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$apiKey}"
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// 回傳錯誤或結果
if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'debug' => 'CURL 連線失敗',
        'error' => $curlError
    ]);
    exit;
}

http_response_code($httpCode);
echo $response;
?>