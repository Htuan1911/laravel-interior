<!-- CSS -->
<style>
    #chatbot-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 70px;
        height: 70px;
        z-index: 10000;
        cursor: grab;
    }

    #chatbot-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        pointer-events: none;
        user-select: none;
    }

    #chatbot-box {
        position: fixed;
        width: 380px;
        max-height: 580px;
        background: white;
        border-radius: 14px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.35);
        z-index: 9999;
        display: none;
        flex-direction: column;
        overflow: hidden;
    }

    #chatbot-header {
        background: linear-gradient(145deg, #2c2c2c, #1a1a1a);
        color: white;
        padding: 12px 15px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    #chatbot-box .body {
        padding: 10px;
        overflow-y: auto;
        height: 300px;
        font-size: 15px;
    }

    #chatbot-box .footer {
        padding: 10px;
        display: flex;
        gap: 5px;
        border-top: 1px solid #ddd;
    }

    #chatbot-box .footer input {
        flex: 1;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    #chatbot-box .footer button {
        padding: 8px 12px;
        background: #222222;
        border: none;
        color: white;
        border-radius: 6px;
    }

    .quick-btns button {
        margin: 5px 5px 0 0;
    }

    .chat-line {
        margin-bottom: 6px;
        white-space: pre-wrap;
        word-break: break-word;
    }

/* MENU DROPDOWN */
    #modeDropdown {
        display: none;
        position: absolute;
        right: 50px;
        top: 50px;
        background: #000;
        border: 1px solid #000;
        border-radius: 6px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
        z-index: 10000;
        background-color: #000 !important;
        color: white !important;
        transition: background 0.3s ease, box-shadow 0.3s ease;

    }

    #modeDropdown .dropdown-item {
        background: transparent;
        color: white;
        padding: 8px 12px;
        border-bottom: 1px solid #222;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    #modeDropdown .dropdown-item:hover {
        background: #222;
        color: #fff;
    }
    #modeToggle:hover {
    background-color: #222 !important;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.15);
    }

    /* NÚT ĐÓNG CHAT */
    #closeChatbot {
        background-color: #222 !important;
        color: white !important;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    #closeChatbot:hover {
        background-color: #222 !important;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
    }


    #contact-button {
        display: none;
        padding: 8px;
        margin: 10px;
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- HTML -->
<div id="chatbot-icon">
    <img src="{{ asset('images/chatbot.png') }}" width="70" draggable="false">
</div>

<div id="chatbot-box" class="d-flex flex-column">
    <header id="chatbot-header">
        <span><i class="bi bi-trash me-2" id="clearChat" title="Xoá đoạn chat"></i></span>
        <span>Hỗ trợ khách hàng</span>
        <div>
            <button class="btn btn-sm text-light" id="modeToggle"><i class="bi bi-list"></i></button>
            <div id="modeDropdown" class="dropdown-menu p-2">
                <button class="dropdown-item mode-option" data-mode="ai">Chat với AI</button>
                <button class="dropdown-item mode-option" data-mode="quick">Câu hỏi thường gặp</button>
                <button class="dropdown-item mode-option" data-mode="contact">Liên hệ trực tiếp</button>
            </div>
            <button class="btn btn-sm text-light " id="closeChatbot"><i class="bi bi-x"></i></button>
        </div>
    </header>

    <div class="body" id="chatbot-messages">
        <p class="text-muted">💬 Xin chào! Tôi có thể giúp gì cho bạn?</p>
    </div>

    <div class="quick-btns px-3 d-none" id="quick-questions">
        <button class="btn btn-outline-primary btn-sm" data-question="Vận Chuyển">Vận chuyển</button>
        <button class="btn btn-outline-primary btn-sm" data-question="Đổi trả">Đổi trả</button>
        <button class="btn btn-outline-primary btn-sm" data-question="Hỗ trợ">Hỗ trợ</button>
        <button class="btn btn-outline-primary btn-sm" data-question="Thanh toán">Thanh toán</button>
        <button class="btn btn-outline-primary btn-sm" data-question="Khuyến mãi">Khuyến mãi</button>
        <button class="btn btn-outline-primary btn-sm" data-question="Kích thước sản phẩm">Kích thước sản phẩm</button>
    </div>

    <button id="contact-button">Chuyển sang trang Liên Hệ</button>

    <form id="chatbot-form" class="footer">
        <input type="text" id="chatbot-input" placeholder="Nhập tin..." autocomplete="off">
        <button type="submit">Gửi</button>
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatbotIcon = document.getElementById('chatbot-icon');
    const chatbotBox = document.getElementById('chatbot-box');
    const clearBtn = document.getElementById('clearChat');
    const modeToggle = document.getElementById('modeToggle');
    const modeDropdown = document.getElementById('modeDropdown');
    const quickQuestions = document.getElementById('quick-questions');
    const contactButton = document.getElementById('contact-button');
    const input = document.getElementById('chatbot-input');
    const form = document.getElementById('chatbot-form');
    const messages = document.getElementById('chatbot-messages');

    let isVisible = false;
    let isDragging = false;
    let offsetX = 0, offsetY = 0;
    let dragStartTime = 0;

    // Kéo icon
    chatbotIcon.addEventListener('mousedown', function (e) {
        isDragging = true;
        dragStartTime = Date.now();
        offsetX = e.clientX - chatbotIcon.getBoundingClientRect().left;
        offsetY = e.clientY - chatbotIcon.getBoundingClientRect().top;
        chatbotIcon.style.right = 'auto';
        chatbotIcon.style.bottom = 'auto';
    });

    document.addEventListener('mousemove', function (e) {
        if (!isDragging) return;
        const x = Math.max(0, Math.min(e.clientX - offsetX, window.innerWidth - chatbotIcon.offsetWidth));
        const y = Math.max(0, Math.min(e.clientY - offsetY, window.innerHeight - chatbotIcon.offsetHeight));
        chatbotIcon.style.left = `${x}px`;
        chatbotIcon.style.top = `${y}px`;
        if (isVisible) positionChatbox(x, y);
    });

    document.addEventListener('mouseup', function () {
        if (!isDragging) return;
        isDragging = false;
        if (Date.now() - dragStartTime < 200) {
            isVisible = !isVisible;
            toggleChatbox();
        }
    });

    function positionChatbox(x, y) {
        chatbotBox.style.left = `${x}px`;
        chatbotBox.style.top = `${y - chatbotBox.offsetHeight - 10}px`;
    }

    function toggleChatbox() {
        chatbotBox.style.display = isVisible ? 'flex' : 'none';
        chatbotBox.style.opacity = isVisible ? '1' : '0';
        if (isVisible) {
            const iconRect = chatbotIcon.getBoundingClientRect();
            positionChatbox(iconRect.left, iconRect.top);
        }
    }

    // Đóng chat
    document.getElementById('closeChatbot').addEventListener('click', () => {
        isVisible = false;
        toggleChatbox();
    });

    // Xoá chat
    clearBtn.addEventListener('click', () => {
        messages.innerHTML = '<p class="text-muted">💬 Cuộc trò chuyện mới đã bắt đầu.</p>';
        input.value = '';
    });

    // Hiển thị menu chọn chế độ
    modeToggle.addEventListener('click', () => {
        modeDropdown.style.display = (modeDropdown.style.display === 'none' || !modeDropdown.style.display) ? 'block' : 'none';
    });

    // Xử lý chọn chế độ
    document.querySelectorAll('.mode-option').forEach(item => {
        item.addEventListener('click', () => {
            const mode = item.dataset.mode;
            modeDropdown.style.display = 'none';
            input.disabled = mode !== 'ai';
            quickQuestions.classList.toggle('d-none', mode !== 'quick');
            contactButton.style.display = (mode === 'contact') ? 'block' : 'none';
        });
    });

    // Câu hỏi thường gặp
    document.querySelectorAll('[data-question]').forEach(btn => {
        btn.addEventListener('click', () => {
            const question = btn.dataset.question;
            appendMessage('Bạn', question);
            fetch('{{ route("chatbot.quick") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question })
            })
            .then(res => res.json())
            .then(data => appendMessage('Bot', data.answer));
        });
    });

    // Gửi tin nhắn
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        appendMessage('Bạn', message);
        input.value = '';
        fetch('{{ route("chat.ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => appendMessage('ChatBot', data.reply))
        .catch(() => appendMessage('ChatBot', 'Có lỗi xảy ra!'));
    });

    function appendMessage(sender, text) {
        const p = document.createElement('p');
        p.className = 'chat-line';
        p.innerHTML = `<strong>${sender}:</strong> ${text}`;
        messages.appendChild(p);
        messages.scrollTop = messages.scrollHeight;
    }

    // Nút liên hệ
    contactButton.addEventListener('click', () => {
        window.location.href = '/contact';
    });
});
</script>
