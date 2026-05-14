<?php include_once 'greendefender.php'; ?>
<?php include_once 'db.php'; ?>

<!-- 網站頁腳 -->
<?php 
// 只有首頁(index.php)才顯示訪問人次
if (basename($_SERVER['PHP_SELF']) === 'index.php'): 
?>
<div style="text-align:center; margin:10px 0;">
    🌐 網站總訪問人次：<?php echo get_total_visits(); ?>
</div>
<?php endif; ?>

<div style="text-align:center; margin:10px 0;">
    © 2026 SDG12 永續生活家學習平台
</div>

<script src="assets/js/modal.js"></script>
</body>
</html>
