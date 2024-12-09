document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const chatMessages = document.getElementById("chat-messages");

    function loadMessages() {
        fetch('/Miroff_Airplanes/composants/chat/load_msg.php')
            .then(response => response.json())
            .then(data => {
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
        const tempMessage = document.createElement("div");
        tempMessage.innerHTML = message;
        tempMessage.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
        tempMessage.style.color = "#fff";
        tempMessage.style.padding = "10px";
        tempMessage.style.margin = "10px 0";
        tempMessage.style.borderRadius = "5px";
        chatMessages.appendChild(tempMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        setTimeout(() => {
            if (tempMessage.parentNode === chatMessages) {
                chatMessages.removeChild(tempMessage);
            }
        }, 5000); // Set the timeout duration to 5 seconds
    }

    chatForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (message.length > 0) {
            fetch('/Miroff_Airplanes/composants/chat/send_msg.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ texte: message })
            })
                .then(response => {
                    if (response.status === 401) {
                        showTemporaryMessage('🚫 Vous devez être <a href="/../login.php">connecté</a> pour utiliser le chat.');
                        throw new Error('Unauthorized'); // Ceci va arrêter l'exécution du .then() suivant
                    }
                    return response.json();
                })
                .then((data) => {
                    chatInput.value = "";
                    loadMessages();
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Optionnel : gestion d'autres types d'erreurs
                });
        }
    });

    setInterval(loadMessages, 5000);
    loadMessages();
});