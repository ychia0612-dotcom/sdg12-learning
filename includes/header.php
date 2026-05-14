<?php
// 取得目前頁面名稱，用於導覽列active狀態
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="nav-left">
        <a href="index.php" style="text-decoration: none; display: flex; align-items: center; gap: 20px;">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCAxMjAgMTIwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPg0KPGRlZnM+DQogIDxsaW5lYXJHcmFkaWVudCBpZD0iZyIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+DQogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6I0U0Q0I2NTtzdG9wLW9wYWNpdHk6MSIgLz4NCiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiNDNDlBM0E7c3RvcC1vcGFjaXR5OjEiIC8+DQogIDwvbGluZWFyR3JhZGllbnQ+DQo8L2RlZnM+DQo8cmVjdCB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgcng9IjI0IiBmaWxsPSJ1cmwoI2cpIi8+DQo8Y2lyY2xlIGN4PSI2MCIgY3k9IjYwIiByPSI0NCIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWRhc2hhcnJheT0iMjQgMTIiLz4NCjxwYXRoIGQ9Ik0zMCA2MEMzMCA0My41IDQzLjUgMzAgNjAgMzBDNzYuNSAzMCA5MCA0My41IDkwIDYwQzkwIDc2LjUgNzYuNSA5MCA2MCA5MCIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2Utd2lkdGg9IjciIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPg0KPHBhdGggZD0iTTQ1IDYwQTE1IDE1IDAgMCAxIDc1IDYwQTE1IDE1IDAgMCAxIDQ1IDYwIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+DQo8L3N2Zz4=" class="sdg-logo" alt="SDG12 Logo">
            <span class="platform-title">SDG12 永續生活家</span>
        </a>
    </div>
    
    <!-- 新增完整導航連結 -->
    <div class="nav-items">
        <a href="index.php" class="nav-item <?php echo $current_page === 'index.php' ? 'active' : ''; ?>">首頁</a>
        <a href="sdg12-intro.php" class="nav-item <?php echo $current_page === 'sdg12-intro.php' ? 'active' : ''; ?>">SDG12介紹</a>
        <a href="sdg12-quiz.php" class="nav-item <?php echo $current_page === 'sdg12-quiz.php' ? 'active' : ''; ?>">知識測驗</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="user.php" class="nav-item <?php echo $current_page === 'user.php' ? 'active' : ''; ?>">會員中心</a>
        <?php endif; ?>
    </div>
    
    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn-danger" style="margin-left: 15px; text-decoration: none;">登出</a>
        <?php else: ?>
            <a href="login.php" class="btn-secondary" style="padding: 10px 20px; font-size: 14px; text-decoration: none;">登入</a>
            <a href="register.php" class="btn-primary" style="padding: 10px 20px; font-size: 14px; margin-left: 10px; text-decoration: none;">註冊</a>
        <?php endif; ?>
    </div>
</nav>
