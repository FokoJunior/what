alert('bonjour');


document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('registerUsername').value;
        const password = document.getElementById('registerPassword').value;

        fetch('backend/index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'register', username, password })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Registration successful');
              } else {
                  alert('Registration failed: ' + (data.message || 'Unknown error'));
              }
          })
          .catch(error => console.error('Error:', error));
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        fetch('backend/index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'login', username, password })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Login successful');
                  // Rediriger l'utilisateur vers la page de chat ou sauvegarder les informations de l'utilisateur
                  window.location.href = 'chat.html'; // Exemple de redirection
              } else {
                  alert('Login failed: ' + (data.message || 'Unknown error'));
              }
          })
          .catch(error => console.error('Error:', error));
    });

    document.getElementById('sendButton').addEventListener('click', function() {
        const message = document.getElementById('chatInput').value;
        if (message.trim()) {
            sendMessage(1, 2, message); // senderId = 1, receiverId = 2 for example
            document.getElementById('chatInput').value = '';
        }
    });

    function sendMessage(senderId, receiverId, message) {
        fetch('backend/index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'sendMessage', senderId, receiverId, message })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  displayMessage(senderId, message);
              } else {
                  alert('Message failed to send: ' + (data.message || 'Unknown error'));
              }
          })
          .catch(error => console.error('Error:', error));
    }

    function displayMessage(senderId, message) {
        const chatMessages = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.textContent = senderId + ': ' + message;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
