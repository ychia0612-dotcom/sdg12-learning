<?php
// 取得目前頁面名稱，用於導覽列active狀態
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="nav-left">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCAxMjAgMTIwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPg0KPGRlZnM+DQogIDxsaW5lYXJHcmFkaWVudCBpZD0iZyIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+DQogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6I0U0Q0I2NTtzdG9wLW9wYWNpdHk6MSIgLz4NCiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiNDNDlBM0E7c3RvcC1vcGFjaXR5OjEiIC8+DQogIDwvbGluZWFyR3JhZGllbnQ+DQo8L2RlZnM+DQo8cmVjdCB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgcng9IjI0IiBmaWxsPSJ1cmwoI2cpIi8+DQo8Y2lyY2xlIGN4PSI2MCIgY3k9IjYwIiByPSI0NCIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWRhc2hhcnJheT0iMjQgMTIiLz4NCjxwYXRoIGQ9Ik0zMCA2MEMzMCA0My41IDQzLjUgMzAgNjAgMzBDNzYuNSAzMCA5MCA0My41IDkwIDYwQzkwIDc2LjUgNzYuNSA5MCA2MCA5MCIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2Utd2lkdGg9IjciIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPg0KPHBhdGggZD0iTTQ1IDYwQTE1IDE1IDAgMCAxIDc1IDYwQTE1IDE1IDAgMCAxIDQ1IDYwIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+DQo8L3N2Zz4=" class="sdg-logo" alt="SDG12 Logo">
        <span class="platform-title">SDG12 永續生活家</span>
    </div>
    <div class="nav-right">
        <a href="index.php" class="home-btn" aria-label="返回首頁">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="homeIconGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#C49A3A" />
                        <stop offset="100%" stop-color="#5D8A66" />
                    </linearGradient>
                </defs>
                <path 
                    d="M3 10.5L12 3L21 10.5V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V10.5Z" 
                    stroke="url(#homeIconGradient)" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round"
                />
                <path 
                    d="M9 21V13H15V21" 
                    stroke="url(#homeIconGradient)" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round"
                />
            </svg>
        </a>
    </div>
</nav>