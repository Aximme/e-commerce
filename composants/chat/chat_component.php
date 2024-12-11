<div id="chat-container">
    <div id="chat-header">Discussion Inter-Membres 🚀
    <button id="close-chat" style="background: none; border: none; color: #fff; float: right; font-size: 16px; cursor: pointer;">x</button>
    </div>
    <div id="chat-messages"></div>
    <form id="chat-form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['auth_token']); ?>">
        <input type="text" id="chat-input" maxlength="256" placeholder="Entrez votre msg" />
        <button type="submit">Envoyer</button>
    </form>
</div>

<button id="toggle-chat" style="position: fixed; bottom: 20px; right: 20px; z-index: 1100; background: #3a3a3a; color: #fff; border: none; border-radius: 50%; width: 50px; height: 50px; cursor: pointer;">
    💬
</button>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatContainer = document.getElementById("chat-container");
        const toggleChat = document.getElementById("toggle-chat");
        const closeChat = document.getElementById("close-chat");
        toggleChat.addEventListener("click", function () {
            chatContainer.classList.add("open");
            toggleChat.style.display = "none";
        });

        closeChat.addEventListener("click", function () {
            chatContainer.classList.remove("open");
            toggleChat.style.display = "block";
        });
    });
</script>

<link rel="stylesheet" href="/Miroff_Airplanes/styles/chat.css">
<script src="/Miroff_Airplanes/composants/chat/chat.js"></script>