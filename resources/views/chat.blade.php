<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot | TEST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #FFFFFF;
            --color-text: #1A1A1A;

            --color-border: #1A1A1A;
            --color-shadow: #1A1A1A;

            --color-input-bg: #F5F5F5;
            --color-input-text: #1A1A1A;
            --color-input-focus-bg: #E0E0E0;
            --color-input-focus-border: #1A1A1A;

            --color-user-message-bg: #E60012;
            --color-user-message-text: #FFFFFF;

            --color-bot-message-bg: #0051BA;
            --color-bot-message-text: #FFFFFF;

            --color-header-bg: #FFD700;
            --color-header-text: #1A1A1A;

            --color-button-bg: #0051BA;
            --color-button-text: #FFFFFF;
            --color-button-hover-bg: #E60012;
            --color-button-hover-text: #FFFFFF;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inconsolata', monospace;
            background-color: var(--color-bg);
            color: var(--color-text);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
        }

        .chat-container {
            max-width: 600px;
            width: 100%;
            height: 80vh;
            display: flex;
            flex-direction: column;
            border: 3px solid var(--color-border);
            box-shadow: 8px 8px 0 var(--color-shadow);
            background: var(--color-bg);
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: var(--color-header-bg);
            color: var(--color-header-text);
            border-bottom: 3px solid var(--color-border);
            box-shadow: 0 4px 0 var(--color-shadow);
            z-index: 10;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .chat-header img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border: 2px solid var(--color-border);
            box-shadow: 4px 4px 0 var(--color-shadow);
        }

        .chat-header-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1.1rem;
            margin-left: 12px;
        }

        .header-right {
            width: 45px;
            height: 45px;
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
            padding: 12px 18px;
            border: 2px solid var(--color-border);
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 4px 4px 0 var(--color-shadow);
        }

        .bot-message {
            background-color: var(--color-bot-message-bg);
            color: var(--color-bot-message-text);
        }

        .user-message {
            background-color: var(--color-user-message-bg);
            color: var(--color-user-message-text);
        }

        .typing-indicator {
            display: inline-flex;
            padding: 12px 18px;
            background-color: var(--color-input-bg);
            border: 2px solid var(--color-border);
            box-shadow: 4px 4px 0 var(--color-shadow);
        }

        .typing-indicator span {
            height: 10px;
            width: 10px;
            background-color: var(--color-text);
            margin: 0 2px;
            display: inline-block;
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
            30% { transform: translateY(-6px); }
        }

        .chat-input-area {
            padding: 12px;
            border-top: 3px solid var(--color-border);
            background-color: var(--color-bg);
            display: flex;
        }

        .chat-input-area input {
            border: 2px solid var(--color-border);
            box-shadow: 4px 4px 0 var(--color-shadow);
            background-color: var(--color-input-bg);
            color: var(--color-input-text);
            border-radius: 0;
        }

        .chat-input-area input:focus {
            background-color: var(--color-input-focus-bg);
            color: var(--color-input-text);
            border-color: var(--color-input-focus-border);
            box-shadow: 4px 4px 0 var(--color-shadow);
            outline: none;
        }

        .chat-input-area button {
            border: 2px solid var(--color-border);
            box-shadow: 4px 4px 0 var(--color-shadow);
            background-color: var(--color-button-bg);
            color: var(--color-button-text);
            border-radius: 0;
        }

        .chat-input-area button:hover {
            background-color: var(--color-button-hover-bg);
            color: var(--color-button-hover-text);
            border-radius: 0;
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <div class="chat-container">

            <!-- Header Proporsional -->
            <div class="chat-header">
                <div class="header-left">
                    <img src="https://ui-avatars.com/api/?name=&background=ffffff&color=000000&size=64" alt="Profile Picture">
                    <span class="chat-header-title">Simple Chatbot</span>
                </div>
                <div class="header-right"></div>
            </div>

            <div class="chat-messages" id="chat-messages">
                <div class="message-container bot">
                    <div class="message bot-message">
                        {{ $welcomeMessage }}
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <form id="chat-form" class="d-flex w-100">
                    <input type="text" id="user-input" class="form-control me-2" placeholder="Type your message..." autocomplete="off" autofocus>
                    <button type="submit" class="btn">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const userInput = document.getElementById('user-input');
            const message = userInput.value.trim();

            if (message) {
                const chatMessages = document.getElementById('chat-messages');
                const userContainer = document.createElement('div');
                userContainer.className = 'message-container user';

                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'message user-message';
                userMessageDiv.textContent = message;

                userContainer.appendChild(userMessageDiv);
                chatMessages.appendChild(userContainer);

                const botContainer = document.createElement('div');
                botContainer.className = 'message-container bot';

                const typingDiv = document.createElement('div');
                typingDiv.className = 'typing-indicator';
                typingDiv.innerHTML = '<span></span><span></span><span></span>';

                botContainer.appendChild(typingDiv);
                chatMessages.appendChild(botContainer);

                chatMessages.scrollTop = chatMessages.scrollHeight;
                userInput.value = '';

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
                    chatMessages.removeChild(botContainer);

                    const newBotContainer = document.createElement('div');
                    newBotContainer.className = 'message-container bot';

                    const botMessageDiv = document.createElement('div');
                    botMessageDiv.className = 'message bot-message';
                    botMessageDiv.textContent = data.reply;

                    newBotContainer.appendChild(botMessageDiv);
                    chatMessages.appendChild(newBotContainer);

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

        document.getElementById('user-input').focus();
    </script>
</body>
</html>
