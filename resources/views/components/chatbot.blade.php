<!-- resources/views/components/chatbot.blade.php -->

<style>
    #chatbot-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;
        z-index: 9999;
    }

    #chatbot-window {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        height: 400px;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        display: none;
        flex-direction: column;
        z-index: 10000;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    #chatbot-header {
        background: #007bff;
        color: white;
        padding: 10px;
        cursor: move;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #chatbot-body {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        font-size: 14px;
    }

    #chatbot-input {
        display: flex;
        border-top: 1px solid #ddd;
    }

    #chatbot-input input {
        flex: 1;
        border: none;
        padding: 10px;
    }

    #chatbot-input button {
        border: none;
        padding: 10px;
        background: #007bff;
        color: white;
    }
</style>

<img id="chatbot-toggle" src="{{ asset('images/chat-icon.png') }}" alt="Chatbot" width="60" height="60">

<div id="chatbot-window">
    <div id="chatbot-header">Hỗ trợ khách hàng</div>
    <div id="chatbot-body"></div>
    <div id="chatbot-input">
        <input type="text" id="chatbot-message" placeholder="Nhập câu hỏi...">
        <button onclick="sendChatbotMessage()">Gửi</button>
    </div>
</div>

<script>
    let isDragging = false;
    let offsetX, offsetY;

    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotHeader = document.getElementById('chatbot-header');

    chatbotToggle.ondblclick = () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'none' ? 'flex' : 'none';
    };

    chatbotHeader.addEventListener('mousedown', function(e) {
        isDragging = true;
        offsetX = e.clientX - chatbotWindow.getBoundingClientRect().left;
        offsetY = e.clientY - chatbotWindow.getBoundingClientRect().top;
    });

    document.addEventListener('mousemove', function(e) {
        if (isDragging) {
            chatbotWindow.style.left = e.clientX - offsetX + 'px';
            chatbotWindow.style.top = e.clientY - offsetY + 'px';
            chatbotWindow.style.bottom = 'auto';
            chatbotWindow.style.right = 'auto';
        }
    });

    document.addEventListener('mouseup', function() {
        isDragging = false;
    });

    function sendChatbotMessage() {
        const message = document.getElementById('chatbot-message').value;
        if (!message.trim()) return;

        const body = document.getElementById('chatbot-body');
        body.innerHTML += `<div><strong>Bạn:</strong> ${message}</div>`;
        document.getElementById('chatbot-message').value = '';

        fetch('{{ route("chatbot.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => {
            body.innerHTML += `<div><strong>Bot:</strong> ${data.answer}</div>`;
            body.scrollTop = body.scrollHeight;
        })
        .catch(err => {
            body.innerHTML += `<div><strong>Bot:</strong> Có lỗi xảy ra.</div>`;
        });
    }
</script>
