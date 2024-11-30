document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const chatMessages = document.getElementById("chat-messages");

    function loadMessages() {
        fetch('/Miroff_Airplanes/composants/chat/load_msg.php')
            .then(response => response.json())
            .then(data => {
                const chatMessages = document.getElementById("chat-messages");
                chatMessages.innerHTML = "";
                data.forEach(message => {
                    const msgElement = document.createElement("div");
                    msgElement.textContent = `${message.nom} dit '${message.texte}'`;
                    chatMessages.appendChild(msgElement);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    document.getElementById("chat-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const chatInput = document.getElementById("chat-input");
        const message = chatInput.value.trim();
        if (message.length > 0) {
            fetch('/Miroff_Airplanes/composants/chat/send_msg.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ texte: message })
            })
                .then(response => response.json())
                .then(() => {
                    chatInput.value = "";
                    loadMessages();
                });
        }
    });

    setInterval(loadMessages, 5000);
    loadMessages();
});



function addMessageToChat(name, text) {
    const chatMessages = document.getElementById('chat-messages');

    const messageElement = document.createElement('div');
    messageElement.classList.add('message');

    const nameElement = document.createElement('span');
    nameElement.classList.add('name');
    nameElement.textContent = name;

    const textElement = document.createElement('span');
    textElement.classList.add('text');
    textElement.textContent = text;

    messageElement.appendChild(nameElement);
    messageElement.appendChild(textElement);

    chatMessages.appendChild(messageElement);

    chatMessages.scrollTop = chatMessages.scrollHeight;
}