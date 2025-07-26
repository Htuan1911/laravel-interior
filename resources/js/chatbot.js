document.addEventListener('DOMContentLoaded', function () {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotBox = document.getElementById('chatbot-box');
    const chatbotHeader = document.getElementById('chatbot-header');
    const clearBtn = document.getElementById('chatbot-clear');
    const messagesContainer = document.getElementById('chatbot-messages');
    const inputField = document.getElementById('chatbot-input');

    // Toggle chatbot visibility
    chatbotToggle.addEventListener('click', () => {
        chatbotBox.classList.toggle('d-none');
    });

    // Dragging
    let isDragging = false, offsetX = 0, offsetY = 0;
    chatbotHeader.addEventListener('mousedown', function (e) {
        isDragging = true;
        offsetX = e.clientX - chatbotBox.offsetLeft;
        offsetY = e.clientY - chatbotBox.offsetTop;
    });

    document.addEventListener('mouseup', () => isDragging = false);

    document.addEventListener('mousemove', function (e) {
        if (isDragging) {
            chatbotBox.style.left = `${e.clientX - offsetX}px`;
            chatbotBox.style.top = `${e.clientY - offsetY}px`;
        }
    });

    // Clear
    clearBtn.addEventListener('click', () => {
        messagesContainer.innerHTML = '';
        inputField.value = '';
    });
});

document.getElementById('chatbot-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');
    const message = input.value.trim();
    if (!message) return;

    messages.innerHTML += `<div><strong>Bạn: </strong> ${message}</div>`;
    input.value = '';

    //google AI
    // fetch('{{ route("vertex.chat") }}', {
    // method: 'POST',
    // headers: {
    //     'Content-Type': 'application/json',
    //     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    // },
    // body: JSON.stringify({ message: inputMessage })
    // })


    // .then(res => res.json())
    // .then(data => {
    //     messages.innerHTML += `<div><strong>ChatBot:</strong> ${data.reply}</div>`;
    //     messages.scrollTop = messages.scrollHeight;
    // })
    // .catch(() => {
    //     messages.innerHTML += `<div><strong>ChatBot:</strong> Có lỗi xảy ra.</div>`;
    // });
    fetch('{{ route("chat.ai") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ message })
    })
    .then(res => res.json())
    .then(data => {
        appendMessage('ChatBot', data.reply);
    })
    .catch(() => {
        appendMessage('ChatBot', 'Có lỗi xảy ra!');
    });


    chatbotBox.classList.toggle('show');
    chatbotBox.style.display = isVisible ? 'flex' : 'none';


});
