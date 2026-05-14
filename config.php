<?php
// 網站基本設定
define('SITE_NAME', 'SDG12 永續生活家');
define('SITE_URL', ''); // 上線時填入您的網址
define('SITE_YEAR', '2026');

// 頁面標題對應
$page_titles = [
    'index' => 'SDG12 永續生活家',
    'sdg12-intro' => '深入了解 SDG12',
    'sdg12-quiz' => 'SDG12 知識測驗',
    'user' => 'SDG12 永續生活家'
];

// 取得目前頁面名稱
function get_current_page() {
    $script = basename($_SERVER['SCRIPT_NAME'], '.php');
    return $script;
}

// 取得頁面標題
function get_page_title() {
    global $page_titles;
    $current_page = get_current_page();
    return isset($page_titles[$current_page]) ? $page_titles[$current_page] : SITE_NAME;
}

// 判斷是否為目前頁面
function is_active($page) {
    return get_current_page() === $page ? 'active' : '';
}
?>