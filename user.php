<?php
// 引入資料庫連線
include 'db.php';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG12 永續生活家</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        /* ======================================
           【1】全域基礎設定
        ====================================== */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* ======================================
           【2】導覽列
        ====================================== */
        .home-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(196, 154, 58, 0.06), rgba(93, 138, 102, 0.06));
            border: 1px solid rgba(196, 154, 58, 0.12);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }

        .home-btn:hover {
            background: linear-gradient(135deg, rgba(196, 154, 58, 0.12), rgba(93, 138, 102, 0.12));
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(196, 154, 58, 0.15);
            border-color: rgba(196, 154, 58, 0.22);
        }
        /* ======================================
           【3】中間大標題區
        ====================================== */
        .hero-section {
            background: linear-gradient(135deg, rgba(196, 154, 58, 0.08) 0%, rgba(93, 138, 102, 0.08) 100%);
            border-radius: 36px;
            min-height: 75vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            margin: 125px 0 70px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(196, 154, 58, 0.15);
        }

        /* 標題文字 */
        .hero-title {
            font-size: 54px;
            font-weight: 900;
            margin-bottom: 45px;
            line-height: 1.3;
            background: linear-gradient(135deg, #C49A3A 0%, #E4CB65 50%, #5D8A66 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        /* 副標題 */
        .hero-subtitle {
            font-size: 22px;
            color: #555;
            max-width: 900px;
            margin: 0 auto;
            line-height: 2.4;
            text-align: center;
        }

        /* ======================================
           【4】分隔線
        ====================================== */
        .section-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 0 auto 35px;
            max-width: 900px;
        }
        .divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, #C49A3A, transparent);
            opacity: 0.3;
        }
        .divider-text {
            font-size: 50px;
            font-weight: 1000;
            color: #8B6914;
            white-space: nowrap;
        }
/* ======================================
   課程卡片 —— 四格一排版
====================================== */
.course-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 50px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.course-card {
    background: white;
    border-radius: 26px;
    padding: 32px 24px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.07);
    text-align: center;
    transition: all 0.3s ease;
    border-left: 8px solid #E4CB65;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 380px;
}
.course-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 55px rgba(0,0,0,0.12);
}

/* 圖示：頂部居中 + 往上微調 */
.course-icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 45px;
            color: white;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #E4CB65, #F0D78C);
}

/* 第二個卡片綠色 */
.course-card:nth-child(2) .course-icon-wrapper {
    background: linear-gradient(135deg, #5D8A66, #7AA885);
}
/* 第三個卡片金色 */
.course-card:nth-child(3) .course-icon-wrapper {
    background: linear-gradient(135deg, #E4CB65, #C49A3A);
}
/* 第四個卡片咖啡色 */
.course-card:nth-child(4) .course-icon-wrapper {
    background: linear-gradient(135deg, #8B6914, #A67C1A);
}

/* 標題：居中 + 間距對稱 */
.course-card h3 {
    font-size: 22px;
    font-weight: 800;
    color: #2A2A2A;
    margin: 0 0 16px;
    flex-shrink: 0;
}

/* 內文：上下垂直居中 + 左右水平居中 */
.course-card p {
    color: #555555;
    line-height: 1.7;
    font-size: 17px;
    text-align: center;
    margin: 0 0 28px;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* 按鈕：底部居中 */
.course-btn {
    padding: 14px 36px;
    border-radius: 30px;
    border: none;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.course-btn-gold   { background: linear-gradient(135deg, #E4CB65, #C49A3A); color: white; }
.course-btn-green  { background: linear-gradient(135deg, #5D8A66, #7AA885); color: white; }
.course-btn-brown  { background: linear-gradient(135deg, #8B6914, #A67C1A); color: white; }

.course-btn:hover {
    transform: scale(1.03);
}

        /* ======================================
           【6】頁尾
        ====================================== */
        .footer {
            text-align: center;
            padding: 25px 20px;
            color: #555;
            background: #fff;
            border-top: 1px solid #E5E5E5;
            margin-top: 20px;
        }

        /* ======================================
           【7】手機/平板版 自動適應
        ====================================== */
        @media (max-width: 1024px) {
            .course-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .course-card { min-height: 360px; }
        }

        @media (max-width: 768px) {
            .course-grid { grid-template-columns: 1fr; gap: 20px; }
            .hero-title { font-size: 32px; }
            .hero-subtitle { font-size: 17px; }
            .course-card { padding: 28px 20px; min-height: auto; }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="hero-section fade-in">
            <h1 class="hero-title">歡迎來到 永續生活家!</h1>
            <p class="hero-subtitle">
                學習，是改變世界最溫柔的力量。<br>
                邀請你與我們一同揭開 SDG 12 的奧秘，讓知識落地成為行動。
            </p>
        </div>

        <div class="section-divider fade-in" style="animation-delay: 0.1s;">
            <div class="divider-line"></div>
            <div class="divider-text">🚀 開始您的永續之旅</div>
            <div class="divider-line"></div>
        </div>

        <div class="course-grid">
            <div class="course-card fade-in" style="animation-delay: 0.15s;">
                <div class="course-icon-wrapper">🌍</div>
                <h3>解鎖全球永續視野</h3>
                <p>前往聯合國永續發展目標官方網站，認識17項永續目標。</p>
                <button class="course-btn course-btn-gold" onclick="window.open('https://globalgoals.tw/')">前往探索</button>
            </div>

            <div class="course-card fade-in" style="animation-delay: 0.2s;">
                <div class="course-icon-wrapper">🌱</div>
                <h3>SDG12 實踐全攻略</h3>
                <p>拆解負責任消費與生產內涵，從理論到日常實踐。</p>
                <button class="course-btn course-btn-green" onclick="location.href='sdg12-intro.php'">開始學習</button>
            </div>

            <div class="course-card fade-in" style="animation-delay: 0.25s;">
                <div class="course-icon-wrapper">🎮</div>
                <h3>永續達人實力測驗</h3>
                <p>趣味闖關測驗，進化為永續達人。</p>
                <button class="course-btn course-btn-gold" onclick="location.href='sdg12-quiz.php'">開始挑戰</button>
            </div>

            <div class="course-card fade-in" style="animation-delay: 0.3s;">
                <div class="course-icon-wrapper">📝</div>
                <h3>發揮你的永續影響力</h3>
                <p>填寫問卷，支持永續學術研究。</p>
                <button class="course-btn course-btn-brown" onclick="window.open('https://forms.gle/dfD9pqBsNbgqGmmT8')">填寫問卷</button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>