// 純彈窗功能
let confirmCallback = null;

/**
 * 顯示普通提示彈窗
 */
function showMessage(title, icon, message) {
    const modal = document.getElementById('messageModal');
    if (!modal) return;
    
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalIcon').textContent = icon;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modalConfirmBtn').style.display = 'none';
    document.getElementById('modalOkBtn').style.display = 'inline-block';
    modal.classList.add('show');
}

/**
 * 顯示確認彈窗
 */
function showConfirm(title, icon, message, callback) {
    const modal = document.getElementById('messageModal');
    if (!modal) return;
    
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalIcon').textContent = icon;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modalOkBtn').style.display = 'none';
    document.getElementById('modalConfirmBtn').style.display = 'inline-block';
    confirmCallback = callback;
    modal.classList.add('show');
}

/**
 * 關閉訊息彈窗
 */
function closeMessageModal() {
    const modal = document.getElementById('messageModal');
    if (modal) modal.classList.remove('show');
}

/**
 * 確認按鈕
 */
function onModalConfirm() {
    closeMessageModal();
    if (confirmCallback) {
        confirmCallback();
        confirmCallback = null;
    }
}