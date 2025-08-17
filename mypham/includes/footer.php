<footer class="bg-light text-center p-4 mt-5 shadow-sm">
  <p class="mb-2">© 2025 Mỹ phẩm chính hãng. Thiết kế bởi bạn ❤️</p>
  <p class="mb-1">📞 Số điện thoại: <a href="tel:0355976580">0355 976 580</a></p>
  <p class="mb-1">📘 Facebook: <a href="https://www.facebook.com/chi.kien.316839" target="_blank">Chi Kiên</a></p>
  <p class="mb-0">💬 Zalo: <a href="https://zalo.me/0355976580" target="_blank">0355 976 580</a></p>
</footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- Chatbot icon -->
<div id="chatbot-icon" onclick="toggleChatbot()">💬</div>

<!-- Chatbot container -->
<div id="chatbot-container" style="display:none;">
  <div id="chat-header">Tư vấn AI 🤖 <span onclick="toggleChatbot()" style="cursor:pointer;">❌</span></div>
  <div id="chat-messages"></div>
  <input type="text" id="chat-input" placeholder="Hỏi về mỹ phẩm..." onkeydown="handleChat(event)">
</div>

<link rel="stylesheet" href="/assets/css/chatbot.css">
<script src="/assets/js/chatbot.js"></script>

</body>
</html>
