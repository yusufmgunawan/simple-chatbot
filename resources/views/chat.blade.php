<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat Bot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            height: 80vh;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f5f5f5;
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }
        .message-container {
            display: flex;
            margin-bottom: 12px;
        }
        .message-container.user {
            justify-content: flex-end;
        }
        .message-container.bot {
            justify-content: flex-start;
        }
        .message {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            position: relative;
            word-wrap: break-word;
        }
        .bot-message {
            background-color: white;
            border-top-left-radius: 5px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
        .user-message {
            background-color: #007bff;
            color: white;
            border-top-right-radius: 5px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
        .typing-indicator {
            display: inline-flex;
            padding: 10px 15px;
            background-color: white;
            border-radius: 18px;
            border-top-left-radius: 5px;
        }
        .typing-indicator span {
            height: 8px;
            width: 8px;
            background-color: #6c757d;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: bounce 1.5s infinite ease-in-out;
        }
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-4px); }
        }
        .chat-input-area {
            padding: 12px;
            background-color: white;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="chat-container shadow">
            <div class="chat-messages" id="chat-messages">
                <!-- Welcome message -->
                <div class="message-container bot">
                    <div class="message bot-message shadow-sm">
                        {{ $welcomeMessage }}
                    </div>
                </div>
            </div>
            
            <div class="chat-input-area">
                <form id="chat-form" class="d-flex">
                    <input type="text" id="user-input" class="form-control me-2" placeholder="Type your message..." autocomplete="off" autofocus>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const userInput = document.getElementById('user-input');
            const message = userInput.value.trim();
            
            if (message) {
                // Add user message to chat (right side)
                const chatMessages = document.getElementById('chat-messages');
                const userContainer = document.createElement('div');
                userContainer.className = 'message-container user';
                
                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'message user-message shadow-sm';
                userMessageDiv.textContent = message;
                
                userContainer.appendChild(userMessageDiv);
                chatMessages.appendChild(userContainer);
                
                // Add typing indicator (left side)
                const botContainer = document.createElement('div');
                botContainer.className = 'message-container bot';
                
                const typingDiv = document.createElement('div');
                typingDiv.className = 'typing-indicator';
                typingDiv.innerHTML = '<span></span><span></span><span></span>';
                
                botContainer.appendChild(typingDiv);
                chatMessages.appendChild(botContainer);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Clear input
                userInput.value = '';
                
                // Send to server
                fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    // Remove typing indicator
                    chatMessages.removeChild(botContainer);
                    
                    // Add bot response (left side)
                    const newBotContainer = document.createElement('div');
                    newBotContainer.className = 'message-container bot';
                    
                    const botMessageDiv = document.createElement('div');
                    botMessageDiv.className = 'message bot-message shadow-sm';
                    botMessageDiv.textContent = data.reply;
                    
                    newBotContainer.appendChild(botMessageDiv);
                    chatMessages.appendChild(newBotContainer);
                    
                    // Scroll to bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                })
                .catch(error => {
                    console.error('Error:', error);
                    chatMessages.removeChild(botContainer);
                    
                    const errorContainer = document.createElement('div');
                    errorContainer.className = 'message-container bot';
                    
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'message bot-message';
                    errorDiv.textContent = 'Sorry, something went wrong. Please try again.';
                    
                    errorContainer.appendChild(errorDiv);
                    chatMessages.appendChild(errorContainer);
                });
            }
        });

        // Auto focus input when page loads
        document.getElementById('user-input').focus();
    </script>
</body>
</html>