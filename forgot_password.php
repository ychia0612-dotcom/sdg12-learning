<?php
include 'db.php';

$error = '';
$success = '';
$show_reset_form = false;
$username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verify_recovery'])) {
        // 驗證恢復碼
        $username = trim($_POST['username']);
        $recovery_code = trim($_POST['recovery_code']);

        if (empty($username) || empty($recovery_code)) {
            $error = "請填寫所有欄位";
        } else {
            // 查詢使用者
            $stmt = $conn->prepare("SELECT id, recovery_code FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                $error = "使用者名稱不存在";
            } else {
                $user = $result->fetch_assoc();
                
                // 驗證恢復碼
                if (password_verify($recovery_code, $user['recovery_code'])) {
                    $show_reset_form = true;
                } else {
                    $error = "恢復碼錯誤";
                }
            }
        }
    } elseif (isset($_POST['reset_password'])) {
        // 重置密碼
        $username = trim($_POST['username']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($new_password) || empty($confirm_password)) {
            $error = "請填寫所有欄位";
            $show_reset_form = true;
        } elseif ($new_password !== $confirm_password) {
            $error = "兩次輸入的密碼不一致";
            $show_reset_form = true;
        } elseif (strlen($new_password) < 6) {
            $error = "密碼長度至少需要6個字元";
            $show_reset_form = true;
        } else {
            // 生成新的恢復碼
            $new_recovery_code = bin2hex(random_bytes(8));
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $hashed_recovery_code = password_hash($new_recovery_code, PASSWORD_DEFAULT);

            // 更新密碼和恢復碼
            $stmt = $conn->prepare("UPDATE users SET password = ?, recovery_code = ? WHERE username = ?");
            $stmt->bind_param("sss", $hashed_password, $hashed_recovery_code, $username);

            if ($stmt->execute()) {
                $success = "密碼重置成功！請保存你的新恢復碼";
                $recovery_code = $new_recovery_code;
            } else {
                $error = "密碼重置失敗，請稍後再試";
                $show_reset_form = true;
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
    <title>忘記密碼 - SDG12 永續生活家</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>忘記密碼</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <div class="recovery-code">
                    <strong>你的新恢復碼：</strong>
                    <span id="recoveryCode"><?php echo $recovery_code; ?></span>
                    <button onclick="copyRecoveryCode()">複製</button>
                </div>
                <p class="warning">⚠️ 此恢復碼僅顯示一次，請立即複製並妥善保存</p>
                <a href="login.php" class="btn">前往登入</a>
            </div>
        <?php elseif ($show_reset_form): ?>
            <form method="POST" action="forgot_password.php">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <div class="form-group">
                    <label for="new_password">新密碼</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">確認新密碼</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-primary">重置密碼</button>
            </form>
        <?php else: ?>
            <form method="POST" action="forgot_password.php">
                <div class="form-group">
                    <label for="username">使用者名稱</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="recovery_code">恢復碼</label>
                    <input type="text" id="recovery_code" name="recovery_code" required>
                </div>
                <button type="submit" name="verify_recovery" class="btn btn-primary">驗證並重置密碼</button>
            </form>
            <p class="auth-link">記得密碼了？<a href="login.php">返回登入</a></p>
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
