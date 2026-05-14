<?php
// 引入資料庫連線
include 'db.php';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <!-- 解決 YouTube 嵌入錯誤 153 -->
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta charset="UTF-8">
    <!-- 行動裝置適應 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG12 知識測驗</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* 網站最外層容器，限制最大寬度並置中 */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        /* 淡入動畫基底樣式 */
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
        /* 淡入動畫：從下方滑入 + 漸顯 */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* 漂浮動畫：用在圖標輕輕上下浮動 */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(196, 154, 58, 0.08) 0%, rgba(93, 138, 102, 0.08) 100%);
            border-radius: 36px;
            min-height: 75vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            margin: 105px 0 70px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(196, 154, 58, 0.15);
        }
        .hero-icon {
            font-size: 75px;
            margin-bottom: 35px;
            animation: float 4s ease-in-out infinite;  /* 循環漂浮 */
        }
        .hero-title {
            font-size: 54px;
            font-weight: 900;
            margin-bottom: 45px;
            line-height: 1.2;
            /* 文字漸層效果 */
            background: linear-gradient(135deg, #C49A3A 0%, #E4CB65 50%, #5D8A66 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }
        .hero-subtitle {
            font-size: 22px;
            color: #555555;
            max-width: 900px;
            margin: 0 auto;
            line-height: 2.4;
            text-align: center;
        }
        /* 區塊基底樣式 */
        .section-block {
            margin-bottom: 90px;
        }
        /* 區塊標題 */
        .section-title {
            font-size: 38px;
            font-weight: 800;
            color: #2A2A2A;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        /* 區塊說明文字 */
        .section-desc {
            font-size: 19px;
            color: #555555;
            line-height: 2.2;
            margin-bottom: 50px;
        }

        /* 按鈕樣式（次要） */
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
        /* 按鈕樣式（主要） */
        .btn-primary {
            padding: 15px 40px;
            border-radius: 30px;
            border: none;
            background: #5D8A66;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-primary:hover {
            background: #C49A3A;
            transform: scale(1.05);
        }

        /* 遊戲中心外框 */
        .game-hub {
            max-width: 1000px;
            margin: 0 auto;
        }
        /* 模式卡片網格（3欄） */
        .mode-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }
        /* 模式卡片（選擇難度/模式） */
        .mode-card {
            background: white;
            border-radius: 26px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 35px rgba(0,0,0,0.07);
            border-left: 10px solid #E4CB65;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* 每張卡片左邊顏色不同 */
        .mode-card:nth-child(2) { border-left-color: #5D8A66; }
        .mode-card:nth-child(3) { border-left-color: #8B6914; }
        /* 卡片懸浮效果 */
        .mode-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 55px rgba(0,0,0,0.12);
        }
        /* 卡片圖標 */
        .mode-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }
        /* 卡片標題 */
        .mode-card h3 {
            font-size: 22px;
            font-weight: 800;
            color: #2A2A2A;
            margin-bottom: 15px;
        }
        /* 卡片說明 */
        .mode-card p {
            color: #555555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        /* 遊戲區域 */
        .game-area-new {
            background: white;
            border-radius: 32px;
            padding: 50px;
            box-shadow: 0 12px 45px rgba(0,0,0,0.07);
            margin-bottom: 40px;
        }
        /* 進度條外框 */
        .progress-bar-new {
            width: 100%;
            height: 12px;
            background: #E5E5E5;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 35px;
        }
        /* 進度條填滿區塊 */
        .progress-fill-new {
            height: 100%;
            background: linear-gradient(90deg, #E4CB65, #5D8A66);
            width: 0%;
            transition: width 0.5s ease;
            border-radius: 10px;
        }
        /* 題目頂部資訊列 */
        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .question-header span {
            font-size: 18px;
            font-weight: 700;
        }
        /* 題目文字 */
        .question-text-new {
            font-size: 24px;
            font-weight: 800;
            color: #2A2A2A;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        /* 選項按鈕網格 */
        .options-grid-new {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        /* 選項按鈕 */
        .option-btn-new {
            background: white;
            border: 3px solid #E5E5E5;
            padding: 20px 28px;
            border-radius: 16px;
            font-size: 17px;
            font-weight: 600;
            color: #2A2A2A;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }
        /* 選項按鈕懸浮（未禁用時） */
        .option-btn-new:hover:not(:disabled) {
            border-color: #E4CB65;
            background: #FFF8EB;
            transform: translateX(8px);
        }
        /* 答對樣式 */
        .option-btn-new.correct {
            background: linear-gradient(135deg, #D4EDDA, #A8D5BA);
            border-color: #5D8A66;
            color: #2C5F3E;
        }
        /* 答錯樣式 */
        .option-btn-new.wrong {
            background: linear-gradient(135deg, #F8D7DA, #F5C6CB);
            border-color: #D9534F;
            color: #721C24;
        }
        /* 按鈕禁用時 */
        .option-btn-new:disabled {
            cursor: not-allowed;
        }

        /* 解析區塊（預設隱藏） */
        .explanation-box {
            background: linear-gradient(135deg, rgba(196,154,58,0.08), rgba(93,138,102,0.08));
            border-radius: 18px;
            padding: 25px;
            margin-top: 25px;
            border-left: 5px solid #E4CB65;
            display: none;
        }
        /* 解析顯示 */
        .explanation-box.show {
            display: block;
        }
        /* 解析標題 */
        .explanation-title {
            font-size: 18px;
            font-weight: 800;
            color: #8B6914;
            margin-bottom: 10px;
        }
        /* 解析內文 */
        .explanation-text {
            font-size: 16px;
            line-height: 1.8;
            color: #2A2A2A;
            white-space: pre-line;
        }

        /* 影片容器 */
        .video-container {
            max-width: 700px;
            width: 100%;
            margin: 0 auto 20px auto;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            aspect-ratio: 16/9;
        }
        /* 影片自適應 */
        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        /* 影片來源文字 */
        .video-source {
            font-size: 13px;
            color: #555555;
            text-align: right;
            max-width: 700px;
            margin: 0 auto 25px auto;
        }

        /* 結果頁面 */
        .result-area-new {
            text-align: center;
        }
        /* 結果圖標 */
        .result-icon-new {
            font-size: 90px;
            margin-bottom: 25px;
            animation: float 3s ease-in-out infinite;
        }
        /* 結果標題 */
        .result-title-new {
            font-size: 38px;
            font-weight: 900;
            margin-bottom: 15px;
            color: #2A2A2A;
        }
        /* 結果分數（漸層文字） */
        .result-score-new {
            font-size: 55px;
            font-weight: 900;
            background: linear-gradient(135deg, #8B6914 0%, #C49A3A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
        }
        /* 結果說明 */
        .result-desc-new {
            font-size: 18px;
            color: #555555;
            line-height: 1.9;
            margin-bottom: 35px;
        }

        /* 排行榜容器 */
        .leaderboard-container {
            max-width: 800px;
            margin: 0 auto;
        }
        /* 排行榜分頁標籤 */
        .leaderboard-tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }
        /* 單一分頁標籤 */
        .leaderboard-tab {
            padding: 12px 30px;
            border-radius: 50px;
            border: 2px solid #E5E5E5;
            background: white;
            font-weight: 700;
            color: #2A2A2A;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        /* 標籤啟用狀態 */
        .leaderboard-tab.active {
            background: linear-gradient(135deg, #E4CB65, #C49A3A);
            color: white;
            border-color: transparent;
        }
        /* 排行榜列表外框 */
        .leaderboard-list {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.07);
        }
        /* 排行榜單一項目 */
        .leaderboard-item {
            display: flex;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px dashed #E5E5E5;
        }
        /* 最後一項不顯示底線 */
        .leaderboard-item:last-child {
            border-bottom: none;
        }
        /* 排名徽章 */
        .rank-badge {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 900;
            font-size: 18px;
            margin-right: 20px;
            flex-shrink: 0;
        }
        /* 1~3名特殊顏色 */
        .rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: white; }
        .rank-2 { background: linear-gradient(135deg, #C0C0C0, #A8A8A8); color: white; }
        .rank-3 { background: linear-gradient(135deg, #CD7F32, #8B4513); color: white; }
        /* 其他名次 */
        .rank-other { background: #E5E5E5; color: #2A2A2A; }
        /* 排行榜資訊區 */
        .leaderboard-info {
            flex: 1;
        }
        /* 玩家名稱 */
        .leaderboard-name {
            font-size: 18px;
            font-weight: 700;
            color: #2A2A2A;
            margin-bottom: 5px;
        }
        /* 玩家分數 */
        .leaderboard-score {
            font-size: 22px;
            font-weight: 900;
            color: #8B6914;
        }

        /* 名字輸入彈窗（預設隱藏） */
        #nameModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 99999;
            align-items: center;
            justify-content: center;
        }
        /* 彈窗內容框 */
        .name-modal-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        .name-modal-box h3 {
            font-size: 26px;
            margin: 0 0 10px 0;
            color: #2A2A2A;
        }
        .name-modal-box p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        /* 名字輸入框 */
        #playerNameInput {
            width: 100%;
            padding: 14px 16px;
            font-size: 16px;
            border: 2px solid #E5E5E5;
            border-radius: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            text-align: center;
        }
        #playerNameInput:focus {
            outline: none;
            border-color: #5D8A66;
        }
        /* 彈窗按鈕區 */
        .name-modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .name-modal-btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }
        /* 取消按鈕 */
        .name-modal-btn.cancel {
            background: #ccc;
            color: #333;
        }
        /* 確認按鈕 */
        .name-modal-btn.confirm {
            background: #5D8A66;
            color: white;
        }
        .name-modal-btn.confirm:hover {
            background: #C49A3A;
        }

        /* 手機版響應式：900px以下變成1欄 */
        @media (max-width: 900px) {
            .mode-grid { grid-template-columns: 1fr; }
        }
        /* 手機版：768px以下縮小文字與間距 */
        @media (max-width: 768px) {
            .hero-section { padding: 40px 25px; min-height: 50vh; margin: 20px 0 40px; }
            .hero-title { font-size: 36px; }
            .hero-subtitle { font-size: 17px; }
            .game-area-new { padding: 35px 25px; }
            .question-text-new { font-size: 20px; }
        }
    </style>
</head>
<body>

<!-- 導覽列 -->
<?php include 'includes/header.php'; ?>

<div class="container">
    <!-- 首頁 -->
    <div id="homeScreen">
        <div class="hero-section fade-in">
            <div class="hero-icon">🎮</div>
            <h1 class="hero-title">SDG12 永續實踐家測驗</h1>
            <p class="hero-subtitle">
                三大獨立挑戰模式，全方位鍛鍊你的永續直覺。<br>
                現在就開啟測驗，登入榮譽榜，用知識守護我們的地球！
            </p>
        </div>

        <!-- 三種遊戲模式 -->
        <div class="mode-grid">
            <div class="mode-card">
                <span class="mode-icon">📝</span>
                <h3>永續大會考</h3>
                <p>挑戰知識極限，成為環保領航員。</p>
                <button class="btn-primary" onclick="startGame('choice')">開始挑戰</button>
            </div>
            <div class="mode-card">
                <span class="mode-icon">⭕❌</span>
                <h3>迷思快閃賽</h3>
                <p>直覺反應快問快答，破除消費偽觀念。</p>
                <button class="btn-primary" onclick="startGame('tf')">開始挑戰</button>
            </div>
            <div class="mode-card">
                <span class="mode-icon">🎬</span>
                <h3>時光放映室</h3>
                <p>走進真實情境，投出改變未來的關鍵票。</p>
                <button class="btn-primary" onclick="startGame('video')">開始挑戰</button>
            </div>
        </div>

        <!-- 功能按鈕 -->
        <div style="display:flex; flex-direction:column; gap:15px; justify-content:center; align-items:center; margin-bottom:40px;">
            <button class="btn-secondary" onclick="showLeaderboard()">🏆 排行榜</button>
            <button class="btn-secondary" onclick="location.href='user.php'">返回</button>
        </div>
    </div>

    <!-- 遊戲畫面 -->
    <div id="gameScreen" style="display:none;">
        <div class="game-area-new fade-in">
            <!-- 進度條 -->
            <div class="progress-bar-new">
                <div class="progress-fill-new" id="progressFill"></div>
            </div>
            <!-- 題目資訊：第幾題 / 總題數 / 得分 -->
            <div class="question-header">
                <span style="color:#8B6914;">第 <span id="currentQ">1</span> / <span id="totalQ">5</span> 題</span>
                <span style="color:#2A2A2A;">得分：<span id="currentScore">0</span></span>
            </div>
            
            <!-- YouTube 影片嵌入容器 -->
            <div id="videoContainer" class="video-container" style="display:none;">
                <iframe 
                    id="youtubeFrame" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    referrerpolicy="no-referrer-when-downgrade"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
            <div id="videoSourceText" class="video-source" style="display:none;"></div>

            <!-- 題目 -->
            <div class="question-text-new" id="questionText"></div>
            <!-- 選項 -->
            <div class="options-grid-new" id="optionsGrid"></div>
            
            <!-- 解析區 -->
            <div id="explanationBox" class="explanation-box">
                <div class="explanation-title">💡 解析</div>
                <div class="explanation-text" id="explanationText"></div>
            </div>
        </div>
        <div style="text-align:center; margin-bottom:40px;">
            <button class="btn-secondary" onclick="backToHub()">返回</button>
        </div>
    </div>

    <!-- 結果畫面 -->
    <div id="resultScreen" style="display:none;">
        <div class="game-area-new result-area-new fade-in">
            <div class="result-icon-new" id="resultIcon">🏆</div>
            <div class="result-title-new" id="resultTitle">測驗完成！</div>
            <div class="result-score-new" id="resultScore">0 / 100 分</div>
            <div class="result-desc-new" id="resultDesc"></div>

            <div style="display:flex; gap:15px; justify-content:center;">
                <button class="btn-primary" onclick="restartGame()">再測一次</button>
                <button class="btn-secondary" onclick="backToHub()">返回</button>
            </div>
        </div>
    </div>

    <!-- 排行榜畫面 -->
    <div id="leaderboardScreen" style="display:none;">
        <div class="leaderboard-container fade-in">
            <div class="hero-section" style="min-height: unset; padding: 35px; margin-bottom: 40px;">
                <div class="hero-icon" style="font-size: 50px; margin-bottom: 15px;">🥇</div>
                <h1 class="hero-title" style="font-size: 40px; margin-bottom: 10px;">榮譽排行榜</h1>
                <p class="hero-subtitle" style="font-size: 18px; margin-bottom: 0;">爭奪「SDG12 永續知識王」！</p>
            </div>

            <!-- 排行榜標籤頁 -->
            <div class="leaderboard-tabs">
                <button class="leaderboard-tab active" onclick="switchTab('choice')">📝 永續大會考</button>
                <button class="leaderboard-tab" onclick="switchTab('tf')">⭕❌ 迷思快閃賽</button>
                <button class="leaderboard-tab" onclick="switchTab('video')">🎬 時光放映室</button>
            </div>

            <!-- 排行榜列表 -->
            <div class="leaderboard-list" id="leaderboardList"></div>
            
            <div style="text-align:center; margin-top: 40px;">
                <button class="btn-secondary" onclick="backToHub()">返回</button>
            </div>
        </div>
    </div>
</div>

<!-- 名字輸入彈窗 -->
<div id="nameModal">
    <div class="name-modal-box">
        <h3>🎉 測驗完成！</h3>
        <p>請輸入你的名字／綽號</p>
        <input type="text" id="playerNameInput" placeholder="請輸入暱稱" autocomplete="off">
        <div class="name-modal-buttons">
            <button class="name-modal-btn cancel" onclick="closeNameModal()">取消</button>
            <button class="name-modal-btn confirm" onclick="savePlayerName()">確定</button>
        </div>
    </div>
</div>

<!-- 頁尾 -->
<?php include 'includes/footer.php'; ?>

<script>
// ==========================
// 1. 每月自動清除排行榜
// 功能：每個月1號自動清空排行榜資料
// ==========================
function autoClearLeaderboardMonthly() {
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth() + 1;
    const lastClear = localStorage.getItem('sdg12_last_clear_month');
    if (!lastClear) {
        localStorage.setItem('sdg12_last_clear_month', `${currentYear}-${currentMonth}`);
        return;
    }
    const [lastY, lastM] = lastClear.split('-').map(Number);
    if (currentYear > lastY || currentMonth > lastM) {
        localStorage.setItem(`sdg12_leaderboard_choice`, JSON.stringify([]));
        localStorage.setItem(`sdg12_leaderboard_tf`, JSON.stringify([]));
        localStorage.setItem(`sdg12_leaderboard_video`, JSON.stringify([]));
        localStorage.setItem('sdg12_last_clear_month', `${currentYear}-${currentMonth}`);
    }
}
autoClearLeaderboardMonthly();

// ==========================
// 2. 音效系統
// 功能：點擊、答對、答錯音效
// ==========================
let audioCtx = null;
function initAudio() {
    try { if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
    catch(e) { console.log("不支援音效"); }
}
function playSound(type) {
    initAudio();
    if (!audioCtx) return;
    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();
    osc.connect(gain); gain.connect(audioCtx.destination);
    const now = audioCtx.currentTime;
    if (type==='click') { osc.frequency.value=600; gain.gain.value=0.1; osc.start(now); osc.stop(now+0.1); }
    else if (type==='correct') { osc.frequency.setValueAtTime(523,now); osc.frequency.setValueAtTime(659,now+0.1); osc.frequency.setValueAtTime(784,now+0.2); gain.gain.value=0.2; osc.start(now); osc.stop(now+0.4); }
    else if (type==='wrong') { osc.frequency.setValueAtTime(200,now); osc.frequency.setValueAtTime(150,now+0.15); gain.gain.value=0.2; osc.start(now); osc.stop(now+0.3); }
}

// ==========================
// 3. 題庫
// 三種模式：選擇題、是非題、影片題
// ==========================
const choiceBank = [
    { q: "SDG12 的全名是什麼？", options: ["負責任消費與生產", "氣候行動", "永續城市", "陸域生態"], ans: 0, exp: "SDG12 的全名是「負責任消費與生產」(Responsible Consumption and Production)，核心是確保永續的消費與生產模式。" },
    { q: "SDG12 是聯合國第幾項永續發展目標？", options: ["第10項", "第12項", "第15項", "第17項"], ans: 1, exp: "SDG12 是聯合國 2015 年訂定的 17 項永續發展目標中的第 12 項。" },
    { q: "下列哪一項不是 SDG12 的核心目標？", options: ["減少食物浪費", "負責任化學品管理", "消除貧窮", "永續公共採購"], ans: 2, exp: "消除貧窮是 SDG1 的目標，不是 SDG12 的核心目標。" },
    { q: "SDG12.3 的目標是在 2030 年將零售與消費端的人均食物浪費減少多少？", options: ["減少三分之一", "減半", "減少四分之一", "完全消除"], ans: 1, exp: "SDG12.3 設定的目標是在 2030 年將全球零售與消費端的食物浪費減半 (Halve)。" },
    { q: "「取之有道、用之有度」最能描述哪個 SDG 的精神？", options: ["SDG7 可負擔的潔淨能源", "SDG12 負責任消費與生產", "SDG13 氣候行動", "SDG15 陸域生態"], ans: 1, exp: "「取之有道、用之有度」正是 SDG12 負責任消費與生產的核心精神。" },
    { q: "下列哪種行為不符合 SDG12 的精神？", options: ["自備購物袋", "購買大量包裝精美的禮品", "二手物品交換", "廚餘回收做堆肥"], ans: 1, exp: "購買大量包裝精美的禮品會造成資源浪費，不符合 SDG12 的精神。" },
    { q: "「沒有真正的廢棄物，只有放錯位置的資源」這句話最能描述什麼概念？", options: ["線性經濟", "循環經濟", "計畫性汰舊", "大量消費"], ans: 1, exp: "這句話描述的是「循環經濟」(Circular Economy) 的核心概念，強調資源的不斷循環利用。" },
    { q: "SDG12.8 的目標是培養全民的什麼？", options: ["財富管理能力", "永續發展識能", "外語能力", "運動習慣"], ans: 1, exp: "SDG12.8 的目標是透過教育提升全民的永續發展識能 (Sustainable Development Literacy)。" },
    { q: "全球每年大約有多少比例的食物被浪費？", options: ["十分之一", "五分之一", "三分之一", "一半"], ans: 2, exp: "聯合國統計顯示，全球每年約有三分之一 (1/3) 的食物被浪費。" },
    { q: "下列哪個不是 SDG12 的三大關鍵領域？", options: ["綠色消費", "循環生產", "太空探索", "永續政策"], ans: 2, exp: "太空探索不是 SDG12 的關鍵領域。" },
    { q: "購物時自備購物袋、拒絕塑膠袋，是在實踐 SDG12 的哪個面向？", options: ["負責任消費", "永續生產", "政策制定", "學術研究"], ans: 0, exp: "這是消費者端的「負責任消費」行為。" },
    { q: "企業將生產過程中的廢料回收再製成新產品，這是屬於？", options: ["線性經濟", "循環經濟", "計畫性汰舊", "過度生產"], ans: 1, exp: "這是循環經濟中「資源循環利用」的實踐。" },
    { q: "SDG12 的目標年份主要是哪一年？", options: ["2025年", "2030年", "2040年", "2050年"], ans: 1, exp: "大部分 SDGs 的核心目標年份都是 2030 年。" },
    { q: "下列哪種消費行為最符合 SDG12 的精神？", options: ["衝動購物，買了不用", "優先選擇無包裝、在地商品", "追求流行，頻繁更換物品", "大量購買一次性產品"], ans: 1, exp: "優先選擇無包裝、在地商品是最符合 SDG12 精神的消費行為。" },
    { q: "「延長物品的使用壽命」屬於 SDG12 的哪個原則？", options: ["Recycle 回收", "Reduce 減量", "Reuse 再利用", "Refuse 拒絕"], ans: 2, exp: "延長物品使用壽命屬於「Reuse 再利用」原則。" },
    { q: "SDG12 希望建立什麼樣的經濟模式？", options: ["大量生產、大量消費、大量丟棄", "資源不斷循環的循環經濟", "只追求經濟成長不顧環境", "資源壟斷的經濟"], ans: 1, exp: "SDG12 希望建立「資源不斷循環的循環經濟」模式。" },
    { q: "下列哪一項屬於 SDG12 所說的「永續公共採購」？", options: ["政府優先採購最便宜的產品", "政府優先採購環保、節能、公平貿易產品", "政府只採購進口產品", "政府隨機採購"], ans: 1, exp: "永續公共採購是指政府優先採購具有環保、節能、公平貿易等永續屬性的產品。" },
    { q: "「從搖籃到搖籃」(Cradle to Cradle) 的設計理念是指？", options: ["產品用完就丟", "產品設計時就考慮未來可完全回收再利用", "產品昂貴且精美", "產品只能使用一次"], ans: 1, exp: "「從搖籃到搖籃」是指產品在設計時就考慮到未來可完全回收再利用，而非用完即丟。" },
    { q: "在 SDG12 的架構中，誰是推動永續的重要角色？", options: ["只有政府", "只有企業", "只有民間團體", "政府、企業、全民都是"], ans: 3, exp: "政府、企業、全民都是推動 SDG12 的重要角色。" },
    { q: "下列哪個不是 SDG12 的 5R 原則？", options: ["Refuse 拒絕", "Reduce 減量", "Reuse 再利用", "Regret 後悔"], ans: 3, exp: "Regret 後悔不是 SDG12 的 5R 原則。5R通常指：Refuse, Reduce, Reuse, Recycle, Repair。" },
    { q: "SDG12.5 的目標是大幅減少廢棄物的產生，透過什麼方式？", options: ["預防、減量、回收、再利用", "全部焚燒", "全部掩埋", "出口到其他國家"], ans: 0, exp: "SDG12.5 強調透過「預防、減量、回收、再利用」來大幅減少廢棄物。" },
    { q: "「食物里程」(Food Miles) 是指？", options: ["食物的熱量", "食物從產地到消費者的距離", "食物的保存期限", "食物的價格"], ans: 1, exp: "食物里程是指食物從產地到消費者手中所經過的距離。" },
    { q: "選擇在地生產的食材有助於 SDG12，主要原因是？", options: ["比較便宜", "減少食物里程與運輸碳排放", "比較好吃", "包裝比較精美"], ans: 1, exp: "主要原因是可以減少食物里程與運輸過程中的碳排放。" },
    { q: "SDG12.6 希望企業將永續資訊納入哪裡？", options: ["機密文件", "企業報告中揭露", "只在內部討論", "完全不談"], ans: 1, exp: "SDG12.6 希望企業將永續資訊在企業報告中公開揭露。" },
    { q: "下列哪種行為是在實踐 SDG12 的「Reduce 減量」？", options: ["購物時不拿過度包裝", "把垃圾分類回收", "把舊衣服捐出去", "使用再生紙"], ans: 0, exp: "購物時不拿過度包裝是從源頭「減量」(Reduce)。" },
    { q: "「產品生命週期評估」(LCA) 是在評估什麼？", options: ["產品的價格", "產品從原料取得、生產、使用到廢棄的環境衝擊", "產品的美觀程度", "產品的保固期限"], ans: 1, exp: "LCA (Life Cycle Assessment) 評估的是產品從原料到廢棄整個生命週期的環境衝擊。" },
    { q: "SDG12 與其他 SDGs 的關係是？", options: ["完全獨立，與其他 SDG 無關", "與其他 SDGs 相互關聯，互相影響", "只與 SDG13 氣候行動有關", "只與 SDG15 陸域生態有關"], ans: 1, exp: "SDG12 與其他 SDGs 相互關聯，互相影響，例如與 SDG2、6、13、14、15 都有密切關係。" },
    { q: "下列哪一項不是 SDG12 希望改變的生產消費模式？", options: ["大量生產", "大量消費", "大量丟棄", "大量循環"], ans: 3, exp: "大量循環是 SDG12 希望建立的，而不是要改變的。" },
    { q: "「綠色化學」是 SDG12.4 的重要概念，它是指？", options: ["綠色的化學物質", "在設計、生產、使用時就減少或消除有害物質", "只使用天然物質，完全不使用化學", "化學物質的顏色"], ans: 1, exp: "綠色化學是指在化學品的設計、生產、使用過程中就減少或消除有害物質的使用與產生。" },
    { q: "SDG12 希望透過公共採購的影響力來帶動市場轉型，因為？", options: ["政府是最大的採購者", "政府有強制力", "政府花錢不需要節省", "政府只買貴的"], ans: 0, exp: "因為政府通常是國內最大的單一採購者，其採購決策具有巨大的市場影響力。" },
    { q: "ESG」是企業永續的重要指標，其中不包含？", options: ["環境 Environment", "社會 Social", "治理 Governance", "利潤 Gain"], ans: 3, exp: "ESG 指的是 Environment (環境)、Social (社會)、Governance (治理)，不包含利潤 Gain。" },
    { q: "在 SDG12 的精神中，「永續消費」是指？", options: ["完全不消費", "消費時考慮環境、社會與經濟影響", "只消費昂貴的產品", "只消費進口產品"], ans: 1, exp: "永續消費是指消費時考慮環境、社會與經濟的三重底線影響，而不是完全不消費。" },
    { q: "下列哪種做法不屬於 SDG12 的「廚餘減少」？", options: ["適量採買", "把剩食變成新料理", "把吃不完的食物直接丟掉", "食材充分利用"], ans: 2, exp: "把吃不完的食物直接丟掉不是廚餘減少，而是浪費。" },
    { q: "SDG12 的「負責任消費與生產」，消費者的角色是？", options: ["完全沒有責任", "用選擇投票，支持永續產品", "只看價格，其他不管", "盡量多消費"], ans: 1, exp: "消費者可以用「用選擇投票」，透過購買決策支持永續產品。" },
    { q: "「計畫性汰舊」(Planned Obsolescence) 是 SDG12 希望改變的，它是指？", options: ["產品設計時就刻意縮短使用壽命", "產品很耐用", "產品可以維修", "產品可以回收"], ans: 0, exp: "計畫性汰舊是指產品在設計時就刻意縮短使用壽命，迫使消費者頻繁更換。" },
    { q: "SDG12 希望建立的消費文化是？", options: ["追求流行，頻繁更換", "買得少、買得好、用得久", "衝動購物", "只看包裝不看內容"], ans: 1, exp: "SDG12 希望建立「買得少、買得好、用得久」的消費文化。" },
    { q: "下列哪一項屬於 SDG12 的「永續生產」？", options: ["生產過程中盡量浪費資源", "生產時考慮環境衝擊與資源效率", "生產廉價但很快就壞的產品", "生產過程中大量排放污染"], ans: 1, exp: "永續生產是指生產時考慮環境衝擊與資源效率。" },
    { q: "「零浪費」(Zero Waste) 的理念是？", options: ["完全不產生任何廢棄物", "透過預防、減量、回收，盡量減少廢棄物", "把所有垃圾都焚燒", "把所有垃圾都掩埋"], ans: 1, exp: "零浪費是一種理念，透過預防、減量、回收等方式，盡量減少廢棄物的產生，而不是絕對的零。" },
    { q: "SDG12 與性別平等 (SDG5) 的關聯是？", options: ["完全無關", "女性往往在資源管理、消費決策中扮演重要角色", "只有男性需要關心 SDG12", "SDG12 只關心女性"], ans: 1, exp: "SDG12 與性別平等有關，因為女性往往在資源管理、家庭消費決策中扮演重要角色。" },
    { q: "下列哪個不是 SDG12 的關鍵字？", options: ["循環經濟", "零浪費", "負責任消費", "太空殖民"], ans: 3, exp: "太空殖民不是 SDG12 的關鍵字。" },
    { q: "SDG12.1 希望在各國建立什麼樣的框架？", options: ["軍事擴張框架", "永續消費與生產政策框架", "貿易壁壘框架", "文化隔離框架"], ans: 1, exp: "SDG12.1 希望各國建立永續消費與生產的政策框架。" },
    { q: "「從搖籃到墳墓」(Cradle to Grave) 是指？", options: ["產品的完整生命週期，從原料到廢棄", "產品很昂貴", "產品可以永遠使用", "產品只能用一次"], ans: 0, exp: "「從搖籃到墳墓」指的是產品從原料取得、生產、使用到廢棄的完整生命週期。" },
    { q: "在 SDG12 中，「供應鏈管理」是指？", options: ["只管自己公司，不管上游下游", "從原料到銷售都考慮永續", "盡量壓低供應商價格", "只跟大企業合作"], ans: 1, exp: "永續供應鏈管理是指從原料到銷售的整個過程都考慮永續性。" },
    { q: "下列哪種行為最符合 SDG12 的「Reuse 再利用」？", options: ["把寶特瓶回收", "購物時不拿塑膠袋", "把玻璃罐拿來當收納罐", "少買不需要的東西"], ans: 2, exp: "把玻璃罐拿來當收納罐是「再利用」(Reuse)，回收是 Recycle，不拿是 Refuse/Reduce。" },
    { q: "SDG12 希望透過教育來培養全民的永續識能，這是哪個目標？", options: ["12.3", "12.5", "12.7", "12.8"], ans: 3, exp: "這是 SDG12.8 的目標。" },
    { q: "「外部成本內部化」是 SDG12 的重要概念，它是指？", options: ["把成本隱藏起來", "讓產品價格反映真實的環境與社會成本", "把成本轉嫁給消費者", "只計算金錢成本"], ans: 1, exp: "外部成本內部化是指讓產品價格反映真實的環境與社會成本（例如污染的代價），而不是將這些成本轉嫁給社會。" },
    { q: "下列哪一項不是 SDG12 希望達成的？", options: ["減少資源浪費", "降低環境負荷", "促進經濟正義", "加速資源耗盡"], ans: 3, exp: "加速資源耗盡不是 SDG12 希望達成的。" },
    { q: "SDG12 的精神可以用哪句話來總結？", options: ["賺大錢最重要", "取之有道、用之有度", "用完就丟、再買就有", "只顧自己、不管他人"], ans: 1, exp: "「取之有道、用之有度」最能總結 SDG12 的精神。" },
    { q: "在 SDG12 的學習中，我們了解到永續是？", options: ["少數人的完美行動", "每個人的不完美努力", "政府的事，與我無關", "企業的事，消費者沒責任"], ans: 1, exp: "永續不是少數人的完美行動，而是每個人的不完美努力。" }
];

const tfBank = [
    { q: "SDG12 的全名是「負責任消費與生產」。", ans: true, exp: "正確。SDG12 的全名是 Responsible Consumption and Production。" },
    { q: "SDG12 是聯合國永續發展目標中的第 10 項。", ans: false, exp: "錯誤。SDG12 是第 12 項。" },
    { q: "「大量生產、大量消費、大量丟棄」的線性經濟是 SDG12 希望改變的。", ans: true, exp: "正確。SDG12 希望以循環經濟取代線性經濟。" },
    { q: "SDG12.3 的目標是在 2030 年將食物浪費減半。", ans: true, exp: "正確。SDG12.3 設定 2030 年將零售與消費端食物浪費減半。" },
    { q: "全球每年約有十分之一的食物被浪費。", ans: false, exp: "錯誤。是約三分之一 (1/3)。" },
    { q: "沒有真正的廢棄物，只有放錯位置的資源」描述的是循環經濟。", ans: true, exp: "正確。這是循環經濟的核心概念。" },
    { q: "SDG12 只跟企業有關，跟消費者無關。", ans: false, exp: "錯誤。SDG12 跟政府、企業、消費者都有關。" },
    { q: "「食物里程」越短越好。", ans: true, exp: "正確。食物里程短代表運輸耗能與碳排放少。" },
    { q: "ESG 指的是環境、社會、治理。", ans: true, exp: "正確。ESG = Environment, Social, Governance。" },
    { q: "「計畫性汰舊」是 SDG12 鼓勵的做法。", ans: false, exp: "錯誤。計畫性汰舊刻意縮短產品壽命，是 SDG12 希望改變的。" },
    { q: "SDG12 的目標年份是 2050 年。", ans: false, exp: "錯誤。主要目標年份是 2030 年。" },
    { q: "「Reduce 減量」是 5R 中的第一步，也是最重要的。", ans: true, exp: "正確。優先順序通常是：Refuse > Reduce > Reuse > Recycle。" },
    { q: "把舊衣服捐出去屬於「Reuse 再利用」。", ans: true, exp: "正確。延長物品使用壽命就是再利用。" },
    { q: "SDG12 希望建立「買得少、買得好、用得久」的消費文化。", ans: true, exp: "正確。這是永續消費的精髓。" },
    { q: "政府的公共採購對市場沒有影響。", ans: false, exp: "錯誤。政府通常是最大採購者，影響力巨大。" },
    { q: "「從搖籃到搖籃」是指產品設計時就考慮未來可回收。", ans: true, exp: "正確。Cradle to Cradle 設計理念。" },
    { q: "SDG12 只關心環境，不關心社會與經濟。", ans: false, exp: "錯誤。SDG12 同樣關心社會公平與經濟層面。" },
    { q: "快時尚 (Fast Fashion) 符合 SDG12 的精神。", ans: false, exp: "錯誤。快時尚造成大量資源浪費與污染。" },
    { q: "「零浪費」是指盡量減少廢棄物，而不是絕對的零。", ans: true, exp: "正確。Zero Waste 是一種理念與目標。" },
    { q: "SDG12.8 是關於永續教育。", ans: true, exp: "正確。SDG12.8 目標是提升全民永續識能。" },
    { q: "選擇在地食材只是為了好吃，跟永續無關。", ans: false, exp: "錯誤。在地食材能減少食物里程與碳排放。" },
    { q: "「外部成本內部化」是讓價格反映真實的環境代價。", ans: true, exp: "正確。例如對污染收費，讓成本反映在價格中。" },
    { q: "SDG12 與 SDG13 氣候行動沒有關聯。", ans: false, exp: "錯誤。生產消費是溫室氣體排放的重要來源。" },
    { q: "「產品生命週期評估」(LCA) 只評估產品的使用階段。", ans: false, exp: "錯誤。LCA 評估從原料到廢棄的完整生命週期。" },
    { q: "永續消費就是完全不消費。", ans: false, exp: "錯誤。是「聰明消費」，不是「完全不消費」。" },
    { q: "SDG12 希望企業在報告中揭露永續資訊。", ans: true, exp: "正確。SDG12.6 要求企業永續資訊揭露。" },
    { q: "把垃圾分類回收就夠了，不需要減量。", ans: false, exp: "錯誤。減量 (Reduce) 優先於回收 (Recycle)。" },
    { q: "「綠色化學」是在生產過程中就減少有害物質。", ans: true, exp: "正確。綠色化學從源頭減少危害。" },
    { q: "SDG12 是少數人的完美行動。", ans: false, exp: "錯誤。是每個人的不完美努力。" },
    { q: "「取之有道、用之有度」符合 SDG12 的精神。", ans: true, exp: "正確。這是 SDG12 的最佳寫照。" },
    { q: "SDG12 只關心已開發國家，不關心開發中國家。", ans: false, exp: "錯誤。SDGs 適用於所有國家。" },
    { q: "「Reuse 再利用」包括修理物品。", ans: true, exp: "正確。修理也是延長物品壽命的再利用。" },
    { q: "大量購買促銷但用不完的東西是節省，符合 SDG12。", ans: false, exp: "錯誤。買了用不完造成浪費，不符合 SDG12。" },
    { q: "SDG12 的 5R 包含「Regret 後悔」。", ans: false, exp: "錯誤。沒有 Regret。" },
    { q: "「永續公共採購」是政府優先買環保節能產品。", ans: true, exp: "正確。政府用採購影響市場。" },
    { q: "SDG12 希望加速資源耗盡。", ans: false, exp: "錯誤。是希望減緩資源耗盡。" },
    { q: "「線性經濟」是「取、做、丟」(Take, Make, Dispose)。", ans: true, exp: "正確。這是線性經濟的特徵。" },
    { q: "SDG12 與性別平等 (SDG5) 有關聯。", ans: true, exp: "正確。女性在資源管理與消費決策中常扮演重要角色。" },
    { q: "「廚餘堆肥」不屬於 SDG12 的範圍。", ans: false, exp: "錯誤。廚餘回收是 SDG12 重要的實踐。" },
    { q: "SDG12 只包含消費端，不包含生產端。", ans: false, exp: "錯誤。SDG12 同時包含消費與生產兩端。" },
    { q: "「衝動購物」符合 SDG12 的消費精神。", ans: false, exp: "錯誤。衝動購物常造成浪費。" },
    { q: "SDG12.4 是關於化學品與廢棄物的安全管理。", ans: true, exp: "正確。SDG12.4 目標是負責任化學品與廢棄物管理。" },
    { q: "「二手物品交換」是一種循環消費。", ans: true, exp: "正確。二手交換讓資源被更充分利用。" },
    { q: "SDG12 認為企業只需要追求利潤最大化。", ans: false, exp: "錯誤。SDG12 認為企業應追求三重底線 (People, Planet, Profit)。" },
    { q: "「節約用水用電」屬於 SDG12 的「Reduce 減量」。", ans: true, exp: "正確。節約資源就是減量。" },
    { q: "SDG12 是 17 項 SDGs 中唯一重要的。", ans: false, exp: "錯誤。所有 SDGs 都同等重要，且相互關聯。" },
    { q: "「包裝精美的禮品」一定比較好，符合 SDG12。", ans: false, exp: "錯誤。過度包裝造成資源浪費。" },
    { q: "SDG12.5 是關於大幅減少廢棄物產生。", ans: true, exp: "正確。SDG12.5 目標是透過預防、減量、回收、再利用減少廢棄物。" },
    { q: "永續是一種生活態度，體現在日常選擇中。", ans: true, exp: "正確。永續不是口號，是日常的每一個選擇。" }
];

const videoBank = [
  {
    title: "循環經濟與永續生活",
    youtubeId: "zCRKvDyyHmI",
    source: "影片來源：YouTube",
    questions: [
      { q: "循環經濟的核心概念是？", options: ["用完即丟", "資源重複利用", "大量生產", "快速消費"], ans: 1, exp: "循環經濟強調「減少、再利用、回收」，讓資源不斷循環" },
      { q: "以下哪一項不是循環經濟的好處？", options: ["減少垃圾", "節省資源", "提高浪費", "降低碳足跡"], ans: 2, exp: "循環經濟的目的就是減少浪費，而非增加浪費" },
      { q: "誰可以推動循環經濟？", options: ["只有企業", "只有政府", "每一個人", "只有科學家"], ans: 2, exp: "從日常減塑、回收開始，每個人都能為循環經濟貢獻力量" },
      { q: "SDG12 與循環經濟的關係是？", options: ["完全無關", "SDG12 就是循環經濟", "SDG12 是循環經濟的重要目標", "只有工廠才需要關心"], ans: 2, exp: "SDG12「負責任消費與生產」正是循環經濟的核心目標之一" },
      { q: "以下哪種行為最符合循環經濟？", options: ["購買一次性塑膠杯", "使用可重複使用的水杯", "隨手丟棄舊衣服", "買多種包裝精美的禮物"], ans: 1, exp: "使用可重複用品能減少一次性垃圾，實踐循環經濟" }
    ]
  },
  {
    title: "食物保存與減少浪費",
    youtubeId: "jDg8DQl7ZeQ",
    source: "影片來源：YouTube",
    questions: [
      { q: "食物上的「最佳賞味期」代表什麼？", options: ["過期就一定不能吃", "超過就會立刻壞掉", "是品質最佳的期限，不代表立刻變質", "超過就一定有毒"], ans: 2, exp: "最佳賞味期是指食物品質最好的時間，只要儲存得當，過期後短時間內仍可食用" },
      { q: "以下哪種方法不能減少食物浪費？", options: ["適量採買", "分裝冷凍保存", "買太多又吃不完", "剩食變化料理"], ans: 2, exp: "過度採買、囤積食物是造成浪費的主要原因之一" },
      { q: "SDG12 希望在 2030 年將食物浪費減少多少？", options: ["完全消除", "減半", "減少10%", "不做任何目標"], ans: 1, exp: "SDG12 明確訂定目標：2030 年前減少全球零售與消費端食物浪費的一半" },
      { q: "以下哪一項不是食物保存的正確觀念？", options: ["熟食放涼再冷藏", "分裝成小份冷凍", "冰箱塞滿所有食物", "了解不同食物的保存方式"], ans: 2, exp: "冰箱塞太滿會影響冷空氣循環，降低保存效果，反而容易讓食物壞掉" },
      { q: "剩食可以怎麼利用？", options: ["直接丟掉", "做成剩食料理", "留到發霉再丟", "全部冷藏保存不管"], ans: 1, exp: "剩飯可做炒飯、剩菜可做湯或咖哩，是減少食物浪費的好方法" }
    ]
  },
  {
    title: "永續消費與綠色生活",
    youtubeId: "-m0YaE8uKcg",
    source: "影片來源：YouTube",
    questions: [
      { q: "永續消費最重要的核心是？", options: ["買越貴越好", "理性選擇、減少浪費", "只追求流行", "大量囤積商品"], ans: 1, exp: "永續消費不是不消費，而是理性選擇、減少多餘浪費" },
      { q: "下列哪項最符合綠色生活？", options: ["隨手丟垃圾", "自備環保杯購物袋", "常用一次性餐具", "過度包裝禮品"], ans: 1, exp: "自備環保器具是落實 SDG12 最日常的實踐方式" },
      { q: "企業推動永續生產主要目的是？", options: ["增加污染", "兼顧環境與社會責任", "只賺錢不顧環境", "大量消耗資源"], ans: 1, exp: "永續生產追求經濟、環境、社會三重平衡" },
      { q: "誰是永續生活的推行者？", options: ["只有政府", "只有企業", "全民都有責任", "與學生無關"], ans: 2, exp: "永續是全民議題，每個人日常選擇都能改變未來" },
      { q: "SDG12 最適合的生活態度是？", options: ["用完即丟", "取之有道、用之有度", "衝動購物", "追求奢華消耗"], ans: 1, exp: "克制消費、珍惜資源，就是 SDG12 最好的實踐" }
    ]
  }
];

// ==========================
// 4. 全域遊戲狀態
// 紀錄目前模式、題目、分數、頁籤
// ==========================
let currentMode='', currentQuestions=[], currentVideo=null, currentQIndex=0, currentScore=0, currentTab='choice';

// ==========================
// 5. 名字彈窗控制
// ==========================
function openNameModal(){document.getElementById('nameModal').style.display='flex';document.getElementById('playerNameInput').focus();}
function closeNameModal(){document.getElementById('nameModal').style.display='none';}
function savePlayerName(){
    let name=document.getElementById('playerNameInput').value.trim();
    if(!name){alert('請輸入名字');return;}
    closeNameModal(); 
    autoSaveScore(name);      // 儲存排行榜
    saveDetailedRecord(name); // 儲存詳細紀錄
}

// ==========================
// 6. 工具函式
// 陣列亂序（洗牌）
// ==========================
function shuffleArray(a){const b=[...a];for(let i=b.length-1;i>0;i--){const j=Math.floor(Math.random()*(i+1));[b[i],b[j]]=[b[j],b[i]];}return b;}

// ==========================
// 7. 畫面切換
// 隱藏所有畫面，只顯示指定畫面
// ==========================
function showScreen(id){
    document.getElementById('homeScreen').style.display = 'none';
    document.getElementById('gameScreen').style.display = 'none';
    document.getElementById('resultScreen').style.display = 'none';
    document.getElementById('leaderboardScreen').style.display = 'none';
    document.getElementById(id).style.display = 'block';
}

// ==========================
// 8. 返回首頁
// ==========================
function backToHub() {
    playSound('click');
    showScreen('homeScreen');
}

// ==========================
// 9. 開始遊戲
// 依模式選擇題庫、隨機抽題、初始化
// ==========================
function startGame(mode){
    playSound('click'); 
    currentMode=mode; 
    currentQIndex=0; 
    currentScore=0; 
    currentVideo=null;

    // 選擇題模式
    if(mode==='choice')currentQuestions=shuffleArray(choiceBank).slice(0,5);
    // 是非題模式
    else if(mode==='tf')currentQuestions=shuffleArray(tfBank).slice(0,5);
    // 影片模式
    else if(mode==='video'){
        currentVideo=shuffleArray(videoBank)[0];
        currentQuestions = shuffleArray(currentVideo.questions).slice(0,2);
    }
    // 顯示總題數
    document.getElementById('totalQ').textContent=currentQuestions.length;
    // 切換到遊戲畫面
    showScreen('gameScreen'); 
    showQuestion();
}

// ==========================
// 10. 顯示單題
// 渲染題目、選項、進度條、影片
// ==========================
function showQuestion(){
    const q=currentQuestions[currentQIndex];
    // 更新題號、分數、進度條
    document.getElementById('currentQ').textContent=currentQIndex+1;
    document.getElementById('currentScore').textContent=currentScore;
    document.getElementById('progressFill').style.width=(currentQIndex/currentQuestions.length*100)+'%';
    // 題目文字
    document.getElementById('questionText').textContent=q.q;
    // 隱藏解析
    document.getElementById('explanationBox').classList.remove('show');

    // 取得影片相關元素
    const vc=document.getElementById('videoContainer');
    const vst=document.getElementById('videoSourceText');
    
    // 如果是影片模式，載入 YouTube 嵌入影片
    if(currentMode==='video'&&currentVideo){
        vc.style.display='block';
        vst.style.display='block';
        vst.textContent=currentVideo.source;
        const ytFrame = document.getElementById('youtubeFrame');
        // 嵌入 URL 加入 enablejsapi=1，提升相容性
        ytFrame.src = `https://www.youtube.com/embed/${currentVideo.youtubeId}?enablejsapi=1`;
    }else{
        vc.style.display='none';
        vst.style.display='none';
        const ytFrame = document.getElementById('youtubeFrame');
        ytFrame.src = "";
    }

    // 產生選項按鈕
    const g=document.getElementById('optionsGrid');g.innerHTML='';
    // 是非題
    if(currentMode==='tf'){
        const t=document.createElement('button');t.className='option-btn-new';t.textContent='⭕正確';t.onclick=()=>selectAnswer(true);g.appendChild(t);
        const f=document.createElement('button');f.className='option-btn-new';f.textContent='❌錯誤';f.onclick=()=>selectAnswer(false);g.appendChild(f);
    }else{
        // 選擇題
        q.options.forEach((o,i)=>{
            const b=document.createElement('button');
            b.className='option-btn-new';
            b.textContent=o;
            b.onclick=()=>selectAnswer(i);
            g.appendChild(b);
        });
    }
}

// ==========================
// 11. 選擇答案
// 判斷對錯、顯示顏色、播放音效、計分
// ==========================
function selectAnswer(s){
    const q=currentQuestions[currentQIndex];
    const btns=document.querySelectorAll('.option-btn-new');
    // 禁用所有按鈕
    btns.forEach(b=>b.disabled=true);
    let c=false;
    // 每題分數（最後一題補滿100）
    let p=Math.floor(100/currentQuestions.length);
    if(currentQIndex===currentQuestions.length-1)p=100-(p*(currentQuestions.length-1));
    
    // 記錄使用者答案
    q.userSelected=s; 
    q.isCorrect=(s===q.ans);
    
    // 是非題判斷
    if(currentMode==='tf'){
        c=s===q.ans;
        if(c){
            btns[s?0:1].classList.add('correct');
            currentScore+=p;
            playSound('correct');
        }else{
            btns[s?0:1].classList.add('wrong');
            btns[q.ans?0:1].classList.add('correct');
            playSound('wrong');
        }
    }else{
        // 選擇題判斷
        c=s===q.ans;
        if(c){
            btns[s].classList.add('correct');
            currentScore+=p;
            playSound('correct');
        }else{
            btns[s].classList.add('wrong');
            btns[q.ans].classList.add('correct');
            playSound('wrong');
        }
    }

    // 顯示解析
    document.getElementById('explanationText').textContent=q.exp;
    document.getElementById('explanationBox').classList.add('show');
    
    // 延遲2.5秒後進入下一題
    setTimeout(()=>{
        currentQIndex++;
        currentQIndex<currentQuestions.length?showQuestion():showResult();
    },2500);
}

// ==========================
// 12. 顯示結果
// 計算最終分數、評級、開啟名字輸入
// ==========================
function showResult(){
    playSound('click');
    showScreen('resultScreen');
    document.getElementById('resultScore').textContent=currentScore+'/100分';
    const p=currentScore/100;
    let i,t,d;
    // 依分數給評價
    if(p>=0.9){i='🏆';t='超級達人';d='你太強了!';}
    else if(p>=0.7){i='🌟';t='很棒';d='知識扎實!';}
    else if(p>=0.5){i='🌱';t='不錯';d='繼續加油!';}
    else{i='📚';t='再加油';d='多學習!';}
    
    document.getElementById('resultIcon').textContent=i;
    document.getElementById('resultTitle').textContent=t;
    document.getElementById('resultDesc').textContent=d;
    
    // 開啟名字彈窗
    openNameModal();
}

// ==========================
// 13. 重新遊戲
// ==========================
function restartGame(){playSound('click');startGame(currentMode);}

// ==========================
// 14. 排行榜功能
// 讀取、儲存、排序、顯示排行榜
// ==========================
function getLB(m){return JSON.parse(localStorage.getItem(`sdg12_leaderboard_${m}`))||[];}
function setLB(m,d){localStorage.setItem(`sdg12_leaderboard_${m}`,JSON.stringify(d));}

// 自動儲存分數到排行榜
function autoSaveScore(n){
    const lb=getLB(currentMode);
    const i=lb.findIndex(x=>x.name===n);
    // 同名最高分覆蓋
    if(i!==-1){
        if(currentScore>lb[i].score)lb[i]={name:n,score:currentScore,time:new Date().toLocaleString()};
    }else{
        // 新增玩家
        lb.push({name:n,score:currentScore,time:new Date().toLocaleString()});
    }
    // 排序 + 最多存100筆
    lb.sort((a,b)=>b.score-a.score);
    setLB(currentMode,lb.slice(0,100));
}

// 顯示排行榜頁面
function showLeaderboard(){playSound('click');showScreen('leaderboardScreen');switchTab(currentTab||'choice');}

// 切換排行榜標籤
function switchTab(m){
    currentTab=m;
    // 切換標籤樣式
    document.querySelectorAll('.leaderboard-tab').forEach(t=>t.classList.remove('active'));
    [...document.querySelectorAll('.leaderboard-tab')].find(t=>t.textContent.includes(m==='choice'?'永續大會考':m==='tf'?'迷思快閃賽':'時光放映室')).classList.add('active');
    
    // 取得該模式排行榜
    const lb=getLB(m);
    const l=document.getElementById('leaderboardList');
    if(!lb.length){l.innerHTML='<div style="text-align:center;padding:40px;">尚無紀錄</div>';return;}
    
    // 渲染前10名
    l.innerHTML=lb.slice(0,10).map((it,idx)=>`
        <div class="leaderboard-item">
            <div class="rank-badge ${idx===0?'rank-1':idx===1?'rank-2':idx===2?'rank-3':'rank-other'}">${idx+1}</div>
            <div class="leaderboard-info"><div class="leaderboard-name">${it.name}</div><div style="font-size:13px;color:#555;">${it.time}</div></div>
            <div class="leaderboard-score">${it.score}分</div>
        </div>
    `).join('');
}

// ==========================
// 15. 儲存詳細答題紀錄
// 記錄每一題答對答錯、答案、解析
// ==========================
function saveDetailedRecord(n){
    const r=JSON.parse(localStorage.getItem('sdg12DetailedRecords'))||[];
    // 整理每一題紀錄
    const det=currentQuestions.map((q,idx)=>{
        let ua,ca;
        if(currentMode==='tf'){
            ua=q.userSelected?'⭕正確':'❌錯誤';
            ca=q.ans?'⭕正確':'❌錯誤';
        }else{
            ua=q.options[q.userSelected]||'未答';
            ca=q.options[q.ans];
        }
        return{
            num:idx+1,
            q:q.q,
            user:ua,
            ans:ca,
            cor:q.isCorrect,
            exp:q.exp
        };
    });
    // 統計正確題數
    const cor=det.filter(x=>x.cor).length;
    // 加入紀錄
    r.unshift({
        id:Date.now(),
        name:n,
        mode:currentMode==='choice'?'永續大會考':currentMode==='tf'?'迷思快閃賽':'時光放映室',
        score:currentScore,
        total:det.length,
        cor:cor,
        wor:det.length-cor,
        det:det,
        time:new Date().toLocaleString()
    });
    // 最多存500筆
    localStorage.setItem('sdg12DetailedRecords',JSON.stringify(r.slice(0,500)));
}
</script>
</body>
</html>