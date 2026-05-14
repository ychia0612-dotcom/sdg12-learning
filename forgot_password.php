<?php
// 使用include_once避免重複包含
include_once 'db.php';

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
            // 檢查資料庫連線是否成功
            if (!$conn) {
                $error = "系統暫時無法處理，請稍後再試";
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
            // 檢查資料庫連線是否成功
            if (!$conn) {
                $error = "系統暫時無法處理，請稍後再試";
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
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>忘記密碼 - SDG12 永續生活家</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .auth-container {
            max-width: 450px;
            margin: 150px auto 50px;
            padding: 50px;
            background: white;
            border-radius: 32px;
            box-shadow: 0 12px 45px rgba(0,0,0,0.07);
        }
        .auth-title {
            text-align: center;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #C49A3A 0%, #5D8A66 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #2A2A2A;
        }
        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #E5E5E5;
            border-radius: 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: #C49A3A;
            box-shadow: 0 0 0 8px rgba(196, 154, 58, 0.12);
        }
        .btn-auth {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #C49A3A 0%, #E4CB65 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(196, 154, 58, 0.35);
        }
        .auth-link {
            text-align: center;
            color: #555;
            line-height: 1.8;
        }
        .auth-link a {
            color: #C49A3A;
            text-decoration: none;
            font-weight: 700;
        }
        .auth-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            background: #F8D7DA;
            color: #721C24;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
        .success-message {
            background: #D4EDDA;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
        .recovery-code {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #C3E6CB;
        }
        .recovery-code span {
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            color: #155724;
            letter-spacing: 2px;
        }
        .recovery-code button {
            background: #28A745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        .warning {
            color: #DC3545;
            font-weight: 700;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="auth-container fade-in">
            <h2 class="auth-title">🔑 忘記密碼</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="success-message">
                    <?php echo $success; ?>
                    <div class="recovery-code">
                        <span id="recoveryCode"><?php echo $recovery_code; ?></span>
                        <button onclick="copyRecoveryCode()">複製</button>
                    </div>
                    <p class="warning">⚠️ 此恢復碼僅顯示一次，請立即複製並妥善保存</p>
                    <a href="login.php" class="btn-auth" style="display: block; text-decoration: none;">前往登入</a>
                </div>
            <?php elseif ($show_reset_form): ?>
                <form method="POST" action="forgot_password.php">
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    <div class="form-group">
                        <label for="new_password">新密碼</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">確認新密碼</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="reset_password" class="btn-auth">重置密碼</button>
                </form>
            <?php else: ?>
                <form method="POST" action="forgot_password.php">
                    <div class="form-group">
                        <label for="username">使用者名稱</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="recovery_code">恢復碼</label>
                        <input type="text" class="form-control" id="recovery_code" name="recovery_code" required>
                    </div>
                    <button type="submit" name="verify_recovery" class="btn-auth">驗證並重置密碼</button>
                </form>

                <div class="auth-link">
                    記得密碼了？<a href="login.php">返回登入</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

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
