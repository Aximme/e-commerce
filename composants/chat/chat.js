let isShowingError = false;


document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const chatMessages = document.getElementById("chat-messages");
    const csrfToken = document.querySelector('input[name="csrf_token"]').value;

    function loadMessages() {
        if (isShowingError) return;
        fetch('/Miroff_Airplanes/composants/chat/load_msg.php')
            .then(response => response.json())
            .then(data => {
                if (isShowingError) return;
                chatMessages.innerHTML = "";
                data.forEach(message => {
                    const msgElement = document.createElement("div");
                    msgElement.textContent = `${message.nom} dit : ${message.texte}`;
                    chatMessages.appendChild(msgElement);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    function showTemporaryMessage(message) {
        isShowingError = true;
        
        const tempMessage = document.createElement("div");
        tempMessage.innerHTML = message;
        tempMessage.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
        tempMessage.style.color = "#fff"; 
        tempMessage.style.padding = "10px";
        tempMessage.style.margin = "10px 0";
        tempMessage.style.borderRadius = "5px";
        
        chatMessages.innerHTML = '';
        chatMessages.appendChild(tempMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        setTimeout(() => {
            isShowingError = false;
            loadMessages();
        }, 5000);
    }

    chatForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (message.length > 0) {
            fetch('/Miroff_Airplanes/composants/chat/send_msg.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ texte: message, csrf_token: csrfToken })
            })
                .then(response => {
                    if (response.status === 401) {
                        showTemporaryMessage('🚫 Vous devez être <a href="/../login.php">connecté</a> pour utiliser le chat.');
                        throw new Error('Unauthorized');
                    } else if (response.status === 403) {
                        showTemporaryMessage('🚫 Message offensant détecté :( Veuillez modifier votre message.');
                        throw new Error('Offensive message or invalid CSRF token');
                    }
                    return response.json();
                })
                .then((data) => {
                    chatInput.value = "";
                    loadMessages();
                })
        }
    });

    setInterval(loadMessages, 5000);
    loadMessages();
});