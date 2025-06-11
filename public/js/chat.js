document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message');
    const sendBtn = document.getElementById('send-btn');
    const sidebar = document.querySelector('.w-64');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    
    // Focus input on page load
    messageInput.focus();
    
    // Toggle sidebar on mobile
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('md:flex');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768 && 
            !sidebar.contains(e.target) && 
            e.target !== sidebarToggle) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('md:flex');
        }
    });
    
    // Append message to chat
    function appendMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex mb-4 max-w-3xl mx-auto ${sender === 'user' ? 'justify-end' : ''}`;
        
        if (sender === 'bot') {
            const avatarDiv = document.createElement('div');
            avatarDiv.className = 'w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center mr-3 flex-shrink-0';
            avatarDiv.innerHTML = '<i class="fas fa-robot text-sm"></i>';
            messageDiv.appendChild(avatarDiv);
        }
        
        const contentDiv = document.createElement('div');
        const messageContent = document.createElement('div');
        messageContent.className = sender === 'user' 
            ? 'bg-purple-600 text-white rounded-2xl px-4 py-3' 
            : 'bg-gray-100 text-gray-800 rounded-2xl px-4 py-3';
        
        // Check for transaction message
        if (text.includes('Transaksi berhasil dicatat')) {
            const parts = text.split('\n');
            messageContent.textContent = parts[0];
            
            const transactionDiv = document.createElement('div');
            transactionDiv.className = 'bg-white rounded-xl p-3 mt-2 border border-gray-200 text-sm';
            
            for (let i = 1; i < parts.length; i++) {
                if (parts[i].trim() === '') continue;
                if (parts[i].includes('Ada lagi')) continue;
                
                const lineDiv = document.createElement('div');
                const colonIndex = parts[i].indexOf(':');
                
                if (colonIndex > -1) {
                    const label = parts[i].substring(0, colonIndex + 1);
                    const value = parts[i].substring(colonIndex + 1);
                    
                    lineDiv.className = 'flex mb-1';
                    lineDiv.innerHTML = `
                        <span class="text-gray-500 font-medium w-24 flex-shrink-0">${label}</span>
                        <span class="text-gray-800">${value}</span>
                    `;
                } else {
                    lineDiv.textContent = parts[i];
                }
                transactionDiv.appendChild(lineDiv);
            }
            
            contentDiv.appendChild(messageContent);
            contentDiv.appendChild(transactionDiv);
            
            // Add closing line
            const closingLine = document.createElement('div');
            closingLine.className = 'bg-gray-100 text-gray-800 rounded-2xl px-4 py-3 mt-2';
            closingLine.textContent = 'Ada lagi yang bisa saya bantu?';
            contentDiv.appendChild(closingLine);
        } else {
            messageContent.textContent = text;
            contentDiv.appendChild(messageContent);
        }
        
        // Add timestamp
        const timeDiv = document.createElement('div');
        timeDiv.className = `text-xs text-gray-500 mt-1 ${sender === 'user' ? 'text-right' : ''}`;
        timeDiv.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        contentDiv.appendChild(timeDiv);
        
        if (sender === 'user') {
            const userAvatar = document.createElement('div');
            userAvatar.className = 'w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center ml-3 flex-shrink-0';
            userAvatar.textContent = 'U';
            messageDiv.appendChild(contentDiv);
            messageDiv.appendChild(userAvatar);
        } else {
            messageDiv.appendChild(contentDiv);
        }
        
        chatBox.appendChild(messageDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Show typing indicator
    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'flex mb-4 max-w-3xl mx-auto';
        typingDiv.id = 'typing-indicator';
        
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center mr-3 flex-shrink-0';
        avatarDiv.innerHTML = '<i class="fas fa-robot text-sm"></i>';
        typingDiv.appendChild(avatarDiv);
        
        const contentDiv = document.createElement('div');
        const typingContent = document.createElement('div');
        typingContent.className = 'bg-gray-100 rounded-2xl px-4 py-3 w-20 flex justify-center gap-1';
        
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.className = 'w-2 h-2 bg-gray-500 rounded-full animate-bounce';
            dot.style.animationDelay = `${i * 0.2}s`;
            typingContent.appendChild(dot);
        }
        
        contentDiv.appendChild(typingContent);
        typingDiv.appendChild(contentDiv);
        chatBox.appendChild(typingDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    
    // Hide typing indicator
    function hideTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    // Send message function
    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        messageInput.value = '';
        messageInput.disabled = true;
        sendBtn.disabled = true;
        
        showTypingIndicator();

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => {
            hideTypingIndicator();
            appendMessage(data.reply || 'No response', 'bot');
        })
        .catch(() => {
            hideTypingIndicator();
            appendMessage('Error saat menghubungi server.', 'bot');
        })
        .finally(() => {
            messageInput.disabled = false;
            sendBtn.disabled = false;
            messageInput.focus();
        });
    }
    
    // Event listeners
    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});