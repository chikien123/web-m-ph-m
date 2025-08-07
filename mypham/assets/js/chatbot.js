function toggleChatbot() {
  const chatbot = document.getElementById('chatbot-container');
  chatbot.style.display = (chatbot.style.display === 'none') ? 'flex' : 'none';
}

function handleChat(e) {
  if (e.key === 'Enter') {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    if (message !== '') {
      appendMessage('Bạn', message);
      input.value = '';
      fetch('/chatbot.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({message: message})
    })
      .then(res => res.json())
      .then(data => {
        appendMessage('AI', data.reply);
      });
    }
  }
}

function appendMessage(sender, text) {
  const chat = document.getElementById('chat-messages');
  const div = document.createElement('div');
  div.innerHTML = `<strong>${sender}:</strong> ${text}`;
  chat.appendChild(div);
  chat.scrollTop = chat.scrollHeight;
}

function sendQuickQuestion(text) {
  document.getElementById('message').value = text;
  document.getElementById('chat-form').submit(); // gửi form như khi gõ tay
}

