<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "請輸入使用者名稱和密碼";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // 登入成功
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // 更新最後登入時間
                $stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->bind_param("i", $user['id']);
                $stmt->execute();
                
                header("Location: user.php");
                exit();
            } else {
                $error = "密碼錯誤";
            }
        } else {
            $error = "使用者名稱不存在";
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
    <title>登入 - SDG12 永續生活家</title>
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
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="auth-container fade-in">
            <h2 class="auth-title">🔐 會員登入</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">使用者名稱</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-auth">登入</button>
            </form>

            <div class="auth-link">
                還沒有帳號？<a href="register.php">立即註冊</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
