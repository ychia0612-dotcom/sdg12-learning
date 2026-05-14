<?php
include 'db.php';

$error = '';
$success = '';
$recovery_code = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 驗證輸入
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "請填寫所有欄位";
    } elseif ($password !== $confirm_password) {
        $error = "兩次輸入的密碼不一致";
    } elseif (strlen($password) < 6) {
        $error = "密碼長度至少需要6個字元";
    } else {
        // 檢查使用者名稱是否已存在
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "使用者名稱已被使用";
        } else {
            // 生成16位隨機恢復碼
            $recovery_code = bin2hex(random_bytes(8));
            
            // 哈希密碼和恢復碼
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_recovery_code = password_hash($recovery_code, PASSWORD_DEFAULT);

            // 插入使用者
            $stmt = $conn->prepare("INSERT INTO users (username, password, recovery_code) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $hashed_recovery_code);

            if ($stmt->execute()) {
                $success = "註冊成功！請務必保存以下恢復碼，忘記密碼時將無法找回帳號";
            } else {
                $error = "註冊失敗，請稍後再試";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊 - SDG12 永續生活家</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>註冊帳號</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <div class="recovery-code">
                    <strong>你的恢復碼：</strong>
                    <span id="recoveryCode"><?php echo $recovery_code; ?></span>
                    <button onclick="copyRecoveryCode()">複製</button>
                </div>
                <p class="warning">⚠️ 此恢復碼僅顯示一次，請立即複製並妥善保存</p>
                <a href="login.php" class="btn">前往登入</a>
            </div>
        <?php else: ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">使用者名稱</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">確認密碼</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">註冊</button>
            </form>
            <p class="auth-link">已有帳號？<a href="login.php">立即登入</a></p>
        <?php endif; ?>
    </div>

    <script>
        function copyRecoveryCode() {
            const code = document.getElementById('recoveryCode').textContent;
            navigator.clipboard.writeText(code).then(() => {
                alert('恢復碼已複製到剪貼簿');
            });
        }
    </script>
</body>
</html>
