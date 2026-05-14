<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>深入了解 SDG12</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        /* 網站最大寬度容器：置中、左右留白 */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* 淡入動畫：讓區塊慢慢出現 */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }

        /* 頁尾樣式 */
        .footer {
            text-align: center;
            padding: 30px 20px;
            color: #555555;
            background: #fff;
            border-top: 1px solid #E5E5E5;
            margin-top: 50px;
        }

        /* ======================================
           動畫關鍵影格 @keyframes
           統一放在前面，方便管理
        ====================================== */
        
        /* 淡入 + 微微向上滑動 */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* 漂浮動畫：標題圖示微微上下浮動 */
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* ======================================
           首頁大標題區 Hero Section
           最上方的大標題、簡介、漸層背景
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
            margin: 70px 0 70px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(196, 154, 58, 0.15);
        }
        .hero-icon {
            font-size: 75px;
            margin-bottom: 35px;
            animation: float 4s ease-in-out infinite;  /* 循環漂浮 */
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
           內容區塊通用樣式
           每個章節的標題、內文、間距
        ====================================== */
        .section-block {
            margin-bottom: 90px;
        }
        .section-title {
            font-size: 38px;
            font-weight: 800;
            color: #2A2A2A;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .section-desc {
            font-size: 19px;
            color: #555555;
            line-height: 2.2;
            margin-bottom: 50px;
        }

        /* ======================================
           核心子目標卡片
        ====================================== */
        .goals-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
        .goal-card {
            background: white;
            border-radius: 26px;
            padding: 40px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.07);
            transition: all 0.3s ease;
            border-left: 10px solid #E4CB65;
        }
        .goal-card:nth-child(even) {
            border-left-color: #5D8A66;
        }
        .goal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 55px rgba(0,0,0,0.12);
        }
        .goal-card h4 {
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #2A2A2A;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .goal-card p {
            color: #555555;
            line-height: 2;
            font-size: 16px;
        }

        /* ======================================
           全球現況數據卡片 (事實清單)
        ====================================== */
        .fact-horizontal-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 40px 0;
        }
        .fact-horizontal-item {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 25px;
            border-left: 6px solid #E4CB65;
            transition: all 0.3s ease;
        }
        /* 每個項目切換不同顏色 */
        .fact-horizontal-item:nth-child(2) { border-left-color: #5D8A66; }
        .fact-horizontal-item:nth-child(3) { border-left-color: #8B6914; }
        .fact-horizontal-item:nth-child(4) { border-left-color: #5D8A66; }
        .fact-horizontal-item:nth-child(5) { border-left-color: #C49A3A; }
        .fact-horizontal-item:hover {
            transform: translateX(10px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        }
        .fact-horizontal-icon {
            font-size: 40px;
            flex-shrink: 0;
        }
        .fact-horizontal-content {
            flex: 1;
        }
        .fact-horizontal-content h4 {
            font-size: 20px;
            font-weight: 800;
            color: #2A2A2A;
            margin-bottom: 8px;
        }
        .fact-horizontal-content p {
            font-size: 16px;
            line-height: 1.7;
            color: #555555;
            margin: 0;
        }

        /* ======================================
           與其他SDG關聯時間軸
        ====================================== */
        .sdg-relation-timeline {
            position: relative;
            padding-left: 30px;
            margin: 40px 0;
        }
        /* 中間垂直線 */
        .sdg-relation-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #E4CB65, #5D8A66);
            border-radius: 4px;
        }
        .relation-item-new {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid rgba(196,154,58,0.1);
        }
        /* 左邊圓點 */
        .relation-item-new::before {
            content: '';
            position: absolute;
            left: -38px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: white;
            border: 4px solid #E4CB65;
            border-radius: 50%;
            z-index: 2;
        }
        .relation-item-new:nth-child(even)::before {
            border-color: #5D8A66;
        }
        .relation-item-new:hover {
            transform: translateX(10px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
            border-color: rgba(196,154,58,0.3);
        }
        .relation-item-new strong {
            font-size: 18px;
            color: #C49A3A;
            display: block;
            margin-bottom: 6px;
        }
        .relation-item-new span {
            font-size: 16px;
            color: #2A2A2A;
            line-height: 1.7;
        }

        /* ======================================
           3R 綠色行動卡片 Reduce Reuse Recycle
        ====================================== */
        .r-container {
            display: grid;
            grid-template-columns: repeat(3,1fr);  /* 一排3個 */
            gap: 30px;
            margin: 20px 0 40px;
        }
        .r-card {
            background: white;
            border-radius: 28px;
            padding: 45px 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border-top: 8px solid #E4CB65;
            text-align: center;
            transition: all 0.3s ease;
        }
        .r-card:nth-child(2) { border-top-color: #5D8A66; }
        .r-card:nth-child(3) { border-top-color: #E4CB65; }
        .r-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        .r-card h4 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #2A2A2A;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .r-card p {
            font-size: 17px;
            line-height: 2;
            color: #555555;
            margin: 0;
        }

        /* ======================================
           日常永續實踐指南 (3大場景卡片)
        ====================================== */
        .practice-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
        }
        .practice-card {
            background: white;
            border-radius: 30px;
            padding: 45px 35px;
            box-shadow: 0 12px 45px rgba(0,0,0,0.07);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 100%;
        }
        .practice-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 65px rgba(0,0,0,0.12);
        }
        /* 卡片上方圓形圖示 */
        .practice-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E4CB65, #F0D78C);
            display: grid;
            place-items: center;
            font-size: 45px;
            color: white;
            margin-bottom: 30px;
        }
        .practice-card:nth-child(2) .practice-icon {
            background: linear-gradient(135deg, #5D8A66, #7AA885);
        }
        .practice-card:nth-child(3) .practice-icon {
            background: linear-gradient(135deg, #8B6914, #A67C1A);
        }
        .practice-card h4 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 22px;
            color: #2A2A2A;
        }
        .practice-card ul {
            list-style: none;
            width: 100%;
        }
        .practice-card li {
            padding: 12px 0;
            color: #555555;
            line-height: 1.8;
            font-size: 16px;
            border-bottom: 1px dashed #E5E5E5;
        }
        .practice-card li:last-child {
            border-bottom: none;
        }

        /* ======================================
           7天永續行動挑戰區
        ====================================== */
        .challenge-block {
            background: linear-gradient(135deg, rgba(196, 154, 58, 0.12) 0%, rgba(93, 138, 102, 0.12) 100%);
            border-radius: 36px;
            padding: 60px;
            border: 1px solid rgba(196, 154, 58, 0.18);
            margin-bottom: 60px;
        }
        .challenge-title {
            font-size: 34px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 50px;
            color: #C49A3A;
        }
        .challenge-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
        .challenge-item {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: all 0.3s ease;
        }
        .challenge-item:hover {
            transform: translateX(15px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.07);
        }
        .challenge-check {
            font-size: 28px;
            color: #5D8A66;
        }
        .challenge-item p {
            font-weight: 600;
            color: #2A2A2A;
            font-size: 17px;
            margin: 0;
            line-height: 1.6;
        }

        /* ======================================
           底部按鈕樣式
        ====================================== */
        .btn-secondary {
            padding: 15px 40px;
            border-radius: 30px;
            border: none;
            background: #5D8A66;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #C49A3A;
            transform: scale(1.05);
        }
    </style>
</head>

<!-- ===================== 網頁HTML結構 ===================== -->
<body>

    <!-- 頂部導覽列：Logo + 標題 -->
    <?php include 'includes/header.php'; ?>

    <!-- 網頁主要內容 -->
    <div class="container">
        <!-- 大標題區 -->
        <div class="hero-section fade-in">
            <div class="hero-icon">🌱</div>
            <h1 class="hero-title">從零開始，輕鬆掌握 SDG 12 永續關鍵</h1>
            <p class="hero-subtitle">
                跨越艱澀的理論框架，我們將核心概念轉化為日常實踐。<br>
                在這裡，永續不再是定義，而是觸手可及的生活力。
            </p>
        </div>

        <!-- 第一單元：什麼是SDG12 + 子目標 + 全球現況 + 關聯性 + 3R -->
        <div class="section-block fade-in" style="animation-delay: 0.1s;">
            <h2 class="section-title">🌍 什麼是 SDG 12？</h2>
            <p class="section-desc">
                SDG 12 全名為「責任消費與生產」，是聯合國 2015 年訂定的 17 項永續發展目標之一，核心是確保永續的消費與生產模式。<br><br>
                簡單來說，SDG 12 要解決的核心問題是：人類長期以來「大量生產、大量消費、大量丟棄」的線性經濟模式，已經遠遠超出地球的承載能力。<br><br>
                它不只是要求企業改變生產方式，更邀請每一位消費者，透過日常的選擇，一起減少對地球的傷害，讓資源能循環永續，留給下一代足夠的生存資源。
            </p>

            <h3 class="section-title" style="font-size:30px; margin-top:40px;">🎯 SDG 12 核心子目標（2030 願景）</h3>
            <div class="goals-grid">
                <div class="goal-card">
                    <h4>📊 12.1 永續消費生產架構</h4>
                    <p>落實永續消費與生產的相關框架，讓各國、企業都能依循執行</p>
                </div>
                <div class="goal-card">
                    <h4>♻️ 12.2 永續資源管理</h4>
                    <p>永續管理與高效使用自然資源，減少過度開採與浪費</p>
                </div>
                <div class="goal-card">
                    <h4>🚮 12.3 減少全球食物浪費</h4>
                    <p>2030 年將全球零售與消費端的食物浪費減半，減少生產端損失</p>
                </div>
                <div class="goal-card">
                    <h4>🔄 12.4 負責任化學品與廢棄物</h4>
                    <p>2020 年達成化學品與廢棄物環保管理，降低人體與環境傷害</p>
                </div>
                <div class="goal-card">
                    <h4>🔄 12.5 減少廢棄物產生</h4>
                    <p>2030 年透過預防、減量、回收、再利用，大幅減少廢棄物</p>
                </div>
                <div class="goal-card">
                    <h4>💼 12.6-12.8 企業與大眾永續</h4>
                    <p>鼓勵企業永續實踐、綠色公共採購、全民永續識能教育</p>
                </div>
            </div>

            <h3 class="section-title" style="font-size:30px; margin-top:60px;">📊 全球現況：為什麼 SDG 12 刻不容緩？</h3>
            <div class="fact-horizontal-list">
                <div class="fact-horizontal-item">
                    <span class="fact-horizontal-icon">🥘</span>
                    <div class="fact-horizontal-content">
                        <h4>食物浪費危機</h4>
                        <p>全球每年約有 13 億噸食物被浪費，相當於全球生產食物的 1/3，卻同時有 8.28 億人面臨嚴重飢餓。</p>
                    </div>
                </div>
                <div class="fact-horizontal-item">
                    <span class="fact-horizontal-icon">🌍</span>
                    <div class="fact-horizontal-content">
                        <h4>資源過度消耗</h4>
                        <p>如果全球維持目前的消費模式，2050 年人類將需要 3 顆地球的資源，才能滿足基本生活需求。</p>
                    </div>
                </div>
                <div class="fact-horizontal-item">
                    <span class="fact-horizontal-icon">🛢️</span>
                    <div class="fact-horizontal-content">
                        <h4>塑膠污染失控</h4>
                        <p>全球每年生產超過 4 億噸塑膠，其中超過 85% 最終成為廢棄物，每年有 800 萬噸塑膠流入海洋，威脅海洋生態與人類健康。</p>
                    </div>
                </div>
                <div class="fact-horizontal-item">
                    <span class="fact-horizontal-icon">👕</span>
                    <div class="fact-horizontal-content">
                        <h4>快時尚的環境代價</h4>
                        <p>紡織業是全球第二大污染產業，一件牛仔褲從生產到丟棄，需要耗費 3781 公升的水，每年有 9200 萬噸紡織廢棄物被掩埋或焚燒。</p>
                    </div>
                </div>
                <div class="fact-horizontal-item">
                    <span class="fact-horizontal-icon">🔥</span>
                    <div class="fact-horizontal-content">
                        <h4>氣候變遷的推手</h4>
                        <p>全球約 45% 的溫室氣體排放，來自於資源開採、產品生產與食物供應鏈，永續消費與生產是對抗氣候變遷的關鍵。</p>
                    </div>
                </div>
            </div>

            <h3 class="section-title" style="font-size:30px; margin-top:60px;">🔗 SDG 12 與其他永續目標的關聯</h3>
            <p class="section-desc" style="margin-bottom:20px;">SDG 12 不是孤立的目標，它是實現多項永續發展的核心基礎：</p>
            <div class="sdg-relation-timeline">
                <div class="relation-item-new">
                    <strong>SDG 2 零飢餓</strong>
                    <span>減少食物浪費，就能讓更多人獲得足夠的食物</span>
                </div>
                <div class="relation-item-new">
                    <strong>SDG 6 淨水與衛生</strong>
                    <span>永續生產能減少水資源污染與過度消耗</span>
                </div>
                <div class="relation-item-new">
                    <strong>SDG 13 氣候行動</strong>
                    <span>減少過度生產與消費，就能大幅降低碳排放</span>
                </div>
                <div class="relation-item-new">
                    <strong>SDG 14 海洋生態</strong>
                    <span>減少塑膠使用與廢棄物，就能守護海洋環境</span>
                </div>
                <div class="relation-item-new">
                    <strong>SDG 15 陸域生態</strong>
                    <span>永續的資源使用，能保護森林與生物多樣性</span>
                </div>
            </div>

            <h3 class="section-title" style="font-size:30px; margin-top:60px;">✅ 3R 綠色行動指南</h3>
            <div class="r-container">
                <div class="r-card">
                    <h4>🔻 Reduce 減量</h4>
                    <p>購物清單、少包裝、不浪費食物、節約水電，從源頭杜絕浪費</p>
                </div>
                <div class="r-card">
                    <h4>♻️ Reuse 重複使用</h4>
                    <p>自備杯袋餐具、修理物品、二手捐贈、容器重複利用</p>
                </div>
                <div class="r-card">
                    <h4>🔄 Recycle 回收</h4>
                    <p>落實分類、選用回收材質、電子廢棄物專門回收、廚餘堆肥</p>
                </div>
            </div>
        </div>

        <!-- 第二單元：日常永續實踐指南 -->
        <div class="section-block fade-in" style="animation-delay: 0.2s;">
            <h2 class="section-title">🏡 日常永續實踐指南</h2>
            <p class="section-desc">
                永續從來不是遙遠的口號，而是藏在你我生活的每一個選擇裡。我們整理了三大場景的完整實踐方法，從購物到居家，從辦公到飲食，讓你從今天開始，就能輕鬆落實 SDG12 的精神，用每一個小選擇，累積改變世界的大力量。
            </p>
            <div class="practice-grid">
                <div class="practice-card">
                    <div class="practice-icon">🛒</div>
                    <h4>聰明消費場景</h4>
                    <ul>
                        <li>購物前先列清單，拒絕衝動消費</li>
                        <li>優先選擇無包裝、簡易包裝商品</li>
                        <li>挑選耐用、可修復、可回收的產品</li>
                        <li>支持在地小農與永續認證商品</li>
                        <li>優先選擇二手物品，延長物品壽命</li>
                        <li>拒絕一次性產品，自備購物袋、餐具</li>
                        <li>閱讀產品標示，瞭解成分與來源</li>
                        <li>不買過量，只買真正需要的東西</li>
                    </ul>
                </div>
                <div class="practice-card">
                    <div class="practice-icon">🍳</div>
                    <h4>居家生活場景</h4>
                    <ul>
                        <li>食材適量採買，減少食物浪費</li>
                        <li>廚餘分類回收，製作堆肥回歸自然</li>
                        <li>落實垃圾分類，提高資源回收率</li>
                        <li>節約用水用電，選用節能家電</li>
                        <li>舊物改造DIY，賦予物品新生命</li>
                        <li>選用天然清潔用品，減少化學污染</li>
                        <li>種植綠色植物，打造居家小森林</li>
                        <li>衣物愛護保養，延長穿著壽命</li>
                    </ul>
                </div>
                <div class="practice-card">
                    <div class="practice-icon">💻</div>
                    <h4>辦公學習場景</h4>
                    <ul>
                        <li>優先雙面列印，減少紙張浪費</li>
                        <li>數位化辦公，減少不必要的紙本輸出</li>
                        <li>自備環保杯，拒絕一次性飲料杯</li>
                        <li>辦公室設置資源回收區，落實分類</li>
                        <li>分享二手書籍與文具，循環利用</li>
                        <li>下班關閉所有電源，節約能源消耗</li>
                        <li>自備便當餐具，減少外食垃圾</li>
                        <li>線上開會，減少通勤碳足跡</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 第三單元：7天永續挑戰 -->
        <div class="challenge-block fade-in" style="animation-delay: 0.3s;">
            <h3 class="challenge-title">📅 7天永續行動挑戰</h3>
            <div class="challenge-list">
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day1：自備購物袋日，全程不使用任何一次性塑膠袋</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day2：食材零浪費日，把剩食變成美味料理</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day3：自備餐具日，全程使用環保杯與環保餐具</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day4：舊物改造日，賦予閒置物品新用途</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day5：在地消費日，支持在地小農，減少食物里程</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day6：零廢棄辦公/上學日，不產生一次性垃圾</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">✅</span>
                    <p>Day7：永續分享日，把理念分享給身邊的人</p>
                </div>
                <div class="challenge-item">
                    <span class="challenge-check">🏆</span>
                    <p>完成挑戰！你已經成為真正的「永續生活家」！</p>
                </div>
            </div>
        </div>

        <!-- 結語 + 返回按鈕 -->
        <div class="section-block fade-in" style="animation-delay: 0.4s; text-align:center;">
            <h2 class="section-title" style="justify-content:center;">💡 永續，從你的第一個選擇開始</h2>
            <p class="section-desc" style="text-align:center; max-width:950px; margin:0 auto 50px;">
                每一次的消費、每一次的選擇，都是你為想要的世界投下的一票。SDG12 從來不是一個人的完美行動，而是每個人的不完美努力。現在，就用你學到的知識，開始你的永續行動吧！
            </p>
            <button class="btn-secondary" onclick="location.href='user.php'">返回</button>
        </div>
    </div>

    <!-- 頁腳 -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
