<?php
// 綠盾衛士 AI 聊天機器人
?>
<style>
#greendefender-fab {
    position: fixed !important;
    bottom: 24px !important;
    right: 24px !important;
    width: 64px !important;
    height: 64px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #5D8A66, #A8D5BA) !important;
    color: white !important;
    font-size: 30px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 8px 24px rgba(93,138,102,0.35) !important;
    z-index: 999999 !important;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
    border: 3px solid white !important;
}
#greendefender-fab:hover {
    transform: scale(1.1) translateY(-3px) !important;
    box-shadow: 0 12px 32px rgba(93,138,102,0.45) !important;
}

#greendefender-modal {
    position: fixed !important;
    bottom: 105px !important;
    right: 24px !important;
    width: 380px !important;
    max-width: calc(100vw - 48px) !important;
    height: 560px !important;
    max-height: calc(100vh - 140px) !important;
    background: #F8F9FA !important;
    border-radius: 22px !important;
    box-shadow: 0 16px 48px rgba(0,0,0,0.18) !important;
    z-index: 999998 !important;
    display: none !important;
    flex-direction: column !important;
    overflow: hidden !important;
    animation: greendefender-fadein 0.35s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
}
#greendefender-modal.show {
    display: flex !important;
}
@keyframes greendefender-fadein {
    from { opacity:0; transform:translateY(20px) scale(0.95); }
    to { opacity:1; transform:translateY(0) scale(1); }
}

#greendefender-header {
    background: linear-gradient(135deg, #5D8A66, #4A7052) !important;
    color: white !important;
    padding: 16px 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
}
#greendefender-header-left {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}
#greendefender-avatar {
    width: 40px !important;
    height: 40px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 26px !important;
    background: rgba(255,255,255,0.2) !important;
    border: 2px solid rgba(255,255,255,0.4) !important;
}
#greendefender-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    margin:0 !important;
    letter-spacing: 0.5px !important;
}
#greendefender-close {
    background: none !important;
    border: none !important;
    color: white !important;
    font-size: 24px !important;
    cursor: pointer !important;
    transition: transform 0.2s ease !important;
    width: 32px !important;
    height: 32px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
}
#greendefender-close:hover {
    transform: rotate(90deg) !important;
    background: rgba(255,255,255,0.15) !important;
}

#greendefender-messages {
    flex:1 !important;
    padding:16px 18px !important;
    overflow-y:auto !important;
    background:#F8F9FA !important;
    display:flex !important;
    flex-direction:column !important;
    gap:16px !important;
    scroll-behavior: smooth !important;
}
#greendefender-messages::-webkit-scrollbar {
    width: 6px !important;
}
#greendefender-messages::-webkit-scrollbar-track {
    background: transparent !important;
}
#greendefender-messages::-webkit-scrollbar-thumb {
    background: #C4C4C4 !important;
    border-radius: 3px !important;
}
#greendefender-messages::-webkit-scrollbar-thumb:hover {
    background: #A0A0A0 !important;
}

#greendefender-quick-container {
    padding:10px 16px !important;
    background:white !important;
    border-top:1px solid #E9ECEF !important;
}
#greendefender-quick-buttons {
    display:flex !important;
    gap:10px !important;
    overflow-x:auto !important;
    padding-bottom: 4px !important;
}
#greendefender-quick-buttons::-webkit-scrollbar {
    height: 4px !important;
}
#greendefender-quick-buttons::-webkit-scrollbar-track {
    background: transparent !important;
}
#greendefender-quick-buttons::-webkit-scrollbar-thumb {
    background: #D0D0D0 !important;
    border-radius: 2px !important;
}
.greendefender-quick-btn {
    background:white !important;
    border:1px solid #DEE2E6 !important;
    color:#495057 !important;
    padding:8px 16px !important;
    border-radius: 20px !important;
    font-size:13px !important;
    font-weight: 500 !important;
    white-space:nowrap !important;
    cursor:pointer !important;
    transition: all 0.2s ease !important;
}
.greendefender-quick-btn:hover {
    background:#5D8A66 !important;
    color:white !important;
    border-color:#5D8A66 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(93,138,102,0.2) !important;
}

/* 對話氣泡核心優化 */
.greendefender-message {
    display:flex !important;
    align-items:flex-end !important;
    gap:10px !important;
    max-width:80% !important;
    width: fit-content !important;
}
.greendefender-message-bot { 
    align-self:flex-start !important; 
    margin-right: auto !important;
}
.greendefender-message-user {
    align-self:flex-end !important;
    flex-direction:row-reverse !important;
    margin-left: auto !important;
}
.greendefender-message-avatar {
    width:36px !important;
    height:36px !important;
    border-radius:50% !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    font-size:18px !important;
    border:2px solid white !important;
    flex-shrink: 0 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
}
.greendefender-message-bot .greendefender-message-avatar {
    background: linear-gradient(135deg, #A8D5BA, #8BC3A3) !important;
    color:white !important;
}
.greendefender-message-user .greendefender-message-avatar {
    background: linear-gradient(135deg, #E0E0E0, #C8C8C8) !important;
    color:#495057 !important;
}
.greendefender-message-bubble {
    padding:12px 18px !important;
    border-radius: 20px !important;
    font-size:14.5px !important;
    line-height:1.65 !important;
    word-wrap: break-word !important;
    max-width: calc(100% - 52px) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
}
.greendefender-message-bot .greendefender-message-bubble {
    background:white !important;
    color:#212529 !important;
    border-bottom-left-radius:6px !important;
}
.greendefender-message-user .greendefender-message-bubble {
    background: linear-gradient(135deg, #5D8A66, #4A7052) !important;
    color:white !important;
    border-bottom-right-radius:6px !important;
}

#greendefender-input-area {
    display:flex !important;
    align-items:center !important;
    gap:10px !important;
    padding:12px 16px !important;
    background:white !important;
    border-top:1px solid #E9ECEF !important;
}
#greendefender-clear {
    background:#F1F3F5 !important;
    border:none !important;
    padding:10px 14px !important;
    border-radius: 18px !important;
    font-size:13px !important;
    font-weight: 500 !important;
    cursor:pointer !important;
    transition: all 0.2s ease !important;
    color:#495057 !important;
}
#greendefender-clear:hover {
    background:#E9ECEF !important;
    transform: translateY(-1px) !important;
}
#greendefender-input {
    flex:1 !important;
    padding:12px 18px !important;
    border:1px solid #DEE2E6 !important;
    border-radius: 24px !important;
    font-size:14.5px !important;
    background:#F8F9FA !important;
    outline:none !important;
    transition: all 0.2s ease !important;
}
#greendefender-input:focus {
    border-color:#5D8A66 !important;
    background:white !important;
    box-shadow: 0 0 0 3px rgba(93,138,102,0.15) !important;
}
#greendefender-send {
    background: linear-gradient(135deg, #5D8A66, #4A7052) !important;
    color:white !important;
    border:none !important;
    width:42px !important;
    height:42px !important;
    border-radius:50% !important;
    cursor:pointer !important;
    transition: all 0.2s ease !important;
    font-size:16px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
#greendefender-send:hover {
    transform: scale(1.05) translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(93,138,102,0.3) !important;
}
#greendefender-send:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
    box-shadow: none !important;
}

@media (max-width:480px) {
    #greendefender-modal {
        width:calc(100vw - 24px) !important;
        right:12px !important;
        bottom:90px !important;
        height: calc(100vh - 120px) !important;
    }
    #greendefender-fab {
        right:12px !important;
        bottom:16px !important;
        width:56px !important;
        height:56px !important;
        font-size:26px !important;
    }
    .greendefender-message {
        max-width:85% !important;
    }
}
</style>

<button id="greendefender-fab">🤖</button>

<div id="greendefender-modal">
    <div id="greendefender-header">
        <div id="greendefender-header-left">
            <div id="greendefender-avatar">🤖</div>
            <h3 id="greendefender-title">綠盾衛士</h3>
        </div>
        <button id="greendefender-close">×</button>
    </div>

    <div id="greendefender-messages"></div>

    <div id="greendefender-quick-container">
        <div id="greendefender-quick-buttons">
            <button class="greendefender-quick-btn">什麼是循環經濟？</button>
            <button class="greendefender-quick-btn">如何減少塑膠使用？</button>
            <button class="greendefender-quick-btn">快時尚的影響？</button>
            <button class="greendefender-quick-btn">食物浪費怎麼辦？</button>
            <button class="greendefender-quick-btn">什麼是5R原則？</button>
            <button class="greendefender-quick-btn">如何實踐永續消費？</button>
        </div>
    </div>

    <div id="greendefender-input-area">
        <button id="greendefender-clear">清空</button>
        <input type="text" id="greendefender-input" placeholder="輸入訊息...">
        <button id="greendefender-send">➤</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let isSending = false;
    const RAILWAY_API_URL = "/proxy.php";

    const chatFab = document.getElementById('greendefender-fab');
    const chatModal = document.getElementById('greendefender-modal');
    const chatCloseBtn = document.getElementById('greendefender-close');
    const chatMessages = document.getElementById('greendefender-messages');
    const chatInput = document.getElementById('greendefender-input');
    const chatSendBtn = document.getElementById('greendefender-send');
    const quickButtons = document.querySelectorAll('.greendefender-quick-btn');
    const chatClearBtn = document.getElementById('greendefender-clear');

    chatFab.addEventListener('click', () => chatModal.classList.toggle('show'));
    chatCloseBtn.addEventListener('click', () => chatModal.classList.remove('show'));

    if (!localStorage.getItem('gd_history')) {
        addBot("嗨！我是綠盾衛士🌱，你的SDG12永續生活小幫手！");
    } else {
        loadHistory();
    }

    async function send() {
        const msg = chatInput.value.trim();
        if (!msg || isSending) return;

        isSending = true;
        chatSendBtn.disabled = true;
        addUser(msg);
        chatInput.value = '';
        addTyping();

        try {
            const res = await fetch(RAILWAY_API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    messages: [
                        { role: "system", content: "你是綠盾衛士，專門解答SDG12負責任消費與生產問題，語氣親切易懂，使用繁體中文，回答條理清晰，重點突出" },
                        { role: "user", content: msg }
                    ]
                })
            });

            const data = await res.json();
            removeTyping();

            if (data.choices?.[0]?.message?.content) {
                addBot(data.choices[0].message.content);
            } else {
                addBot("抱歉，我暫時無法回應，請稍後再試");
            }
            saveHistory();
        } catch (e) {
            removeTyping();
            addBot("抱歉，發生錯誤，請稍後再試");
        } finally {
            isSending = false;
            chatSendBtn.disabled = false;
        }
    }

    chatSendBtn.addEventListener('click', send);
    chatInput.addEventListener('keypress', e => e.key === 'Enter' && send());

    quickButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            chatInput.value = btn.textContent;
            send();
        });
    });

    chatClearBtn.addEventListener('click', () => {
        chatMessages.innerHTML = '';
        localStorage.clear();
        addBot("對話已清空！有什麼關於SDG12的問題都可以問我哦 😊");
    });

    function addUser(text) { addMsg('user', text); }
    function addBot(text) { addMsg('bot', text); }
    function addMsg(role, text) {
        const div = document.createElement('div');
        div.className = `greendefender-message greendefender-message-${role}`;
        const avatar = role === 'bot' ? '🤖' : '👤';
        div.innerHTML = `
            <div class="greendefender-message-avatar">${avatar}</div>
            <div class="greendefender-message-bubble">${text}</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTyping() {
        const t = document.createElement('div');
        t.className = 'greendefender-message greendefender-message-bot';
        t.id = 'gd-typing';
        t.innerHTML = `
            <div class="greendefender-message-avatar">🤖</div>
            <div class="greendefender-message-bubble">正在思考中...</div>
        `;
        chatMessages.appendChild(t);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTyping() {
        const t = document.getElementById('gd-typing');
        if (t) t.remove();
    }

    function saveHistory() {
        const arr = [];
        document.querySelectorAll('.greendefender-message-bubble').forEach(m => arr.push(m.textContent));
        localStorage.setItem('gd_history', JSON.stringify(arr));
    }

    function loadHistory() {
        const hist = JSON.parse(localStorage.getItem('gd_history') || '[]');
        hist.forEach((m, i) => addMsg(i % 2 === 0 ? 'bot' : 'user', m));
    }
});
</script>