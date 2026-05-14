<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
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
        if ($stmt->get_result()->num_rows > 0) {
            $error = "使用者名稱已被使用";
        } else {
            // 檢查Email是否已存在
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $error = "Email已被註冊";
            } else {
                // 註冊新使用者
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    $success = "註冊成功！請登入";
                    header("refresh:2; url=login.php");
                } else {
                    $error = "註冊失敗，請稍後再試";
                }
            }
        }
        $stmt->close();
    }
}

close_db();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊 - SDG12 永續生活家</title>
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
            background: linear-gradient(135deg, #5D8A66 0%, #7AA885 100%);
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
            box-shadow: 0 8px 20px rgba(93, 138, 102, 0.35);
        }
        .auth-link {
            text-align: center;
            color: #555;
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
            color: #2C5F3E;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="auth-container fade-in">
            <h2 class="auth-title">✨ 會員註冊</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">使用者名稱</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">電子郵件</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼 (至少6個字元)</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">確認密碼</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn-auth">註冊</button>
            </form>

            <div class="auth-link">
                已有帳號？<a href="login.php">立即登入</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
