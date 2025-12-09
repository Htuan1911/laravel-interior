<!-- resources/views/components/chatbot.blade.php -->

<style>
    /* Icon chat tròn */
    #chat-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
        line-height: 60px;
        cursor: pointer;
        font-size: 28px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        transition: transform 0.2s ease, background 0.3s ease;
    }

    #chat-icon:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #0056b3, #004494);
    }

    /* Hộp chat */
    #chat-box {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 360px;
        height: 520px;
        background: #fff;
        display: none;
        flex-direction: column;
        z-index: 9999;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        animation: fadeIn 0.3s ease;
        transition: transform 0.2s ease-in-out, opacity 0.3s ease;
    }

    #chat-box.dragging {
        opacity: 0.9;
        cursor: move;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
    }

    #chat-box.show {
        display: flex;
    }

    /* Hiệu ứng fade */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header chat */
    #chat-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 12px 15px;
        font-weight: bold;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: move;
    }

    #chat-header button {
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    /* Nội dung chat */
    #chat-messages {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        font-size: 14px;
        background: #f5f7fb;
        scroll-behavior: smooth;
    }

    .message {
        margin-bottom: 12px;
        max-width: 85%;
        padding: 10px 14px;
        border-radius: 16px;
        clear: both;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .message.user {
        background: #007bff;
        color: white;
        float: right;
        border-bottom-right-radius: 5px;
    }

    .message.bot {
        background: #e8ebf1;
        float: left;
        border-bottom-left-radius: 5px;
    }

    /* Ảnh trong tin nhắn */
    .message img {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 6px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .message img:hover {
        transform: scale(1.02);
    }

    /* Input chat */
    #chat-input {
        display: flex;
        border-top: 1px solid #ddd;
        background: white;
    }

    #chat-input input {
        flex: 1;
        border: none;
        padding: 12px;
        outline: none;
        font-size: 14px;
    }

    #chat-input button {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 0 18px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    #chat-input button:hover {
        background: #0056b3;
    }

    /* Menu chế độ chat */
    #chat-modes {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        margin-bottom: 10px;
        background: #f5f7fb;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .mode-btn {
        flex: 1 1 45%;
        text-align: center;
        padding: 10px 14px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .mode-btn:hover {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .mode-btn.active {
        background: #0056b3;
        color: #fff;
        border-color: #004494;
    }

    /* Câu hỏi nhanh */
    #quick-questions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 10px;
        background: #f9f9fb;
        border-top: 1px solid #ddd;
        max-height: 150px;
        overflow-y: auto;
    }

    #quick-questions .quick-btn {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid #0d6efd;
        border-radius: 8px;
        background: #fff;
        color: #0d6efd;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        text-align: left;
        transition: all 0.3s ease;
    }

    #quick-questions .quick-btn:hover {
        background: #0d6efd;
        color: #fff;
    }

    /* Nút quay lại */
    #back-to-modes {
        margin: 10px;
    }

    .back-btn {
        border-radius: 6px;
        font-size: 14px;
        padding: 8px 14px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: 0.2s;
        color: #333;
        font-weight: 500;
    }

    .back-btn:hover {
        background-color: #e9ecef;
        border-color: #bbb;
    }

    /* Ẩn nhanh */
    .d-none {
        display: none !important;
    }
</style>

<!-- Icon chat -->
<div id="chat-icon">💬</div>

<!-- Hộp chat -->
<div id="chat-box">
    <div id="chat-header">
        💬 Chatbot Style House
        <button id="close-chat">&times;</button>
    </div>

    <!-- Menu chọn chế độ -->
    <div id="chat-modes">
        <button class="mode-btn" data-mode="recommend">🛒 Gợi ý sản phẩm</button>
        <button class="mode-btn" data-mode="ai">🤖 Chat AI</button>
        <button class="mode-btn" data-mode="faq">❓ Câu hỏi nhanh</button>
    </div>

    <!-- Thanh quay lại -->
    <div id="back-to-modes" class="d-none">
        <button id="back-btn" class="back-btn">⬅ Quay lại</button>
    </div>

    <!-- Câu hỏi nhanh -->
    <div id="quick-questions" class="d-none">
        <button class="quick-btn" data-question="Vận chuyển">🚚 Vận chuyển</button>
        <button class="quick-btn" data-question="Đổi trả">🔄 Đổi trả</button>
        <button class="quick-btn" data-question="Thanh toán">💳 Thanh toán</button>
        <button class="quick-btn" data-question="Khuyến mãi">🎁 Khuyến mãi</button>
        <button class="quick-btn" data-question="Kích thước sản phẩm">📐 Kích thước sản phẩm</button>
    </div>

    <!-- Khu vực tin nhắn -->
    <div id="chat-messages"></div>

    <!-- Input chat -->
    <div id="chat-input">
        <input type="text" id="message" placeholder="Nhập tin nhắn...">
        <button id="send-btn">Gửi</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatIcon = document.getElementById('chat-icon');
        const chatBox = document.getElementById('chat-box');
        const closeChat = document.getElementById('close-chat');
        const backToModes = document.getElementById("back-to-modes");
        const chatMessages = document.getElementById('chat-messages');
        const chatHeader = document.getElementById("chat-header");
        const quickQuestions = document.getElementById('quick-questions');
        const chatModes = document.getElementById("chat-modes");

        let currentMode = null;
        let isDragging = false;
        let offsetX, offsetY;

        // Kéo thả chatbox
        chatHeader.addEventListener("mousedown", (e) => {
            isDragging = true;
            offsetX = e.clientX - chatBox.getBoundingClientRect().left;
            offsetY = e.clientY - chatBox.getBoundingClientRect().top;
            chatBox.style.transition = "none";
        });
        document.addEventListener("mousemove", (e) => {
            if (isDragging) {
                chatBox.style.left = `${e.clientX - offsetX}px`;
                chatBox.style.top = `${e.clientY - offsetY}px`;
                chatBox.style.right = "auto";
                chatBox.style.bottom = "auto";
            }
        });
        document.addEventListener("mouseup", () => {
            isDragging = false;
            chatBox.style.transition = "";
        });

        // Bật / Tắt Chatbox
        chatIcon.addEventListener("click", () => chatBox.classList.toggle("show"));
        closeChat.addEventListener("click", () => chatBox.classList.remove("show"));

        // Thêm & cập nhật tin nhắn
        function appendMessage(sender, text) {
            let id = 'msg-' + Date.now();
            chatMessages.innerHTML += `<div id="${id}" class="message ${sender}">${text}</div>`;
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return id;
        }

        function updateMessage(id, newText, sender) {
            let el = document.getElementById(id);
            if (el) {
                el.className = 'message ' + sender;
                el.innerHTML = newText;
            }
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function formatBotReply(text) {
            let urlPattern = /(https?:\/\/[^\s]+)/g;
            return text.replace(urlPattern, url => {
                if (url.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
                    return `<br><img src="${url}" alt="Hình ảnh sản phẩm">`;
                }
                return `<a href="${url}" target="_blank">${url}</a>`;
            });
        }

        // Chọn chế độ
        document.querySelectorAll(".mode-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".mode-btn").forEach(b => b.classList.remove(
                    "active"));
                btn.classList.add("active");
                currentMode = btn.dataset.mode;
                chatMessages.innerHTML = "";

                if (currentMode === "faq") {
                    appendMessage('bot',
                        '❓ Chọn một câu hỏi thường gặp bên dưới để xem câu trả lời.');
                    quickQuestions.classList.remove('d-none');
                } else {
                    quickQuestions.classList.add('d-none');
                    appendMessage('bot', `✅ Bạn đã chọn chế độ: <b>${btn.innerText}</b>.`);
                }
                chatModes.classList.add("d-none");
                backToModes.classList.remove("d-none");
            });
        });
        document.getElementById("back-btn").addEventListener("click", () => {
            chatModes.classList.remove("d-none");
            backToModes.classList.add("d-none");
            quickQuestions.classList.add("d-none");
            chatMessages.innerHTML = "";
            currentMode = null;
        });

        // Câu hỏi nhanh
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('quick-btn')) {
                let question = e.target.dataset.question;
                appendMessage('user', question);
                let loadingId = appendMessage('bot', '<i>Đang tìm câu trả lời...</i>');
                let defaultAnswer = "";
                switch (question) {
                    case "Vận chuyển":
                        defaultAnswer =
                            "🚚 Chúng tôi giao hàng toàn quốc trong 2-5 ngày tùy khu vực. Đơn hàng sẽ được đóng gói an toàn và có mã vận đơn để bạn dễ dàng theo dõi.";
                        break;
                    case "Đổi trả":
                        defaultAnswer =
                            "🔄 Bạn có thể đổi trả sản phẩm trong vòng 7 ngày nếu có lỗi từ nhà sản xuất. Vui lòng giữ nguyên hộp và phụ kiện khi gửi lại để được hỗ trợ nhanh chóng.";
                        break;
                    case "Thanh toán":
                        defaultAnswer =
                            "💳 Chúng tôi hỗ trợ thanh toán khi nhận hàng (COD) và chuyển khoản ngân hàng. Bạn có thể lựa chọn phương thức phù hợp nhất khi đặt hàng.";
                        break;
                    case "Khuyến mãi":
                        defaultAnswer =
                            "🎁 Giảm ngay 10% cho đơn hàng đầu tiên từ 2 triệu đồng. Ngoài ra, chúng tôi thường xuyên có các chương trình ưu đãi vào dịp lễ và cuối tuần.";
                        break;
                    case "Kích thước sản phẩm":
                        defaultAnswer =
                            "📐 Kích thước chi tiết của sản phẩm được ghi rõ trong phần mô tả. Nếu bạn cần tư vấn chọn kích thước phù hợp với không gian, hãy Liên hệ với chúng tôi để hỗ trợ.";
                        break;
                    default:
                        defaultAnswer =
                            "❓ Xin lỗi, hiện tại chúng tôi chưa có sẵn câu trả lời cho vấn đề này. Bạn có thể để lại thông tin để nhân viên hỗ trợ trực tiếp.";
                }


                fetch("{{ route('chatbot.quick') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            question
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        let answer = data.answer || defaultAnswer;
                        updateMessage(loadingId, answer, 'bot');
                        if (currentMode === "faq") quickQuestions.classList.remove("d-none");
                    })
                    .catch(() => {
                        updateMessage(loadingId, defaultAnswer, 'bot');
                        if (currentMode === "faq") quickQuestions.classList.remove("d-none");
                    });
            }
        });

        // Gửi tin nhắn thủ công
        document.getElementById('send-btn').addEventListener('click', sendMessage);
        document.getElementById('message').addEventListener('keypress', e => {
            if (e.key === 'Enter') sendMessage();
        });

        function sendMessage() {
            let msg = document.getElementById('message').value.trim();
            if (!msg || !currentMode) {
                alert("Vui lòng chọn chế độ trước khi chat!");
                return;
            }
            appendMessage('user', msg);
            document.getElementById('message').value = '';
            let loadingId = appendMessage('bot', '<i>Đang trả lời...</i>');

            let url = '';
            if (currentMode === 'ai') url = "{{ route('chatbot.ai') }}";
            else if (currentMode === 'faq') url = "{{ route('chatbot.quick') }}";
            else url = "{{ route('chatbot.send') }}";

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: msg
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let reply = data.reply || data.answer || "⚠️ Không có phản hồi.";
                    updateMessage(loadingId, formatBotReply(reply), 'bot');
                })
                .catch(() => {
                    updateMessage(loadingId, '⚠️ Lỗi kết nối!', 'bot');
                });
        }
    });
</script>
