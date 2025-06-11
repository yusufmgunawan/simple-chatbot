<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MonTrek AI | Money Tracker AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-50 border-r border-gray-200 flex flex-col h-full transition-all duration-300 ease-in-out">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center gap-2 text-purple-700 mb-4">
                <i class="fas fa-robot text-xl"></i>
                <span class="text-lg font-semibold">MonTrek AI</span>
            </div>
            <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-md flex items-center justify-center gap-2 transition-colors">
                <i class="fas fa-plus"></i> New Chat
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto py-2">
            <div class="px-4 py-3 flex items-center gap-3 bg-gray-200 text-gray-800 cursor-pointer">
                <i class="fas fa-comment text-gray-600"></i>
                <span>Current Chat</span>
            </div>
            <div class="px-4 py-3 flex items-center gap-3 hover:bg-gray-100 text-gray-600 cursor-pointer">
                <i class="fas fa-comment"></i>
                <span>Budget Planning</span>
            </div>
            <div class="px-4 py-3 flex items-center gap-3 hover:bg-gray-100 text-gray-600 cursor-pointer">
                <i class="fas fa-comment"></i>
                <span>Expense Tracking</span>
            </div>
        </div>
        
        <div class="p-4 border-t border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-medium">U</div>
                <span class="text-gray-700">User</span>
            </div>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-cog"></i>
            </button>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full bg-white">
        <!-- Header -->
        <div class="h-16 border-b border-gray-200 flex items-center px-4 gap-4">
            <button class="text-gray-500 md:hidden sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="text-lg font-medium text-gray-800">AI Financial Assistant</h2>
        </div>
        
        <!-- Chat Container -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Chat Box -->
            <div id="chat-box" class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <div class="text-center text-gray-500 text-sm mb-6">Today</div>
                
                <!-- Welcome Message -->
                <div class="flex mb-4 max-w-3xl mx-auto">
                    <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-robot text-sm"></i>
                    </div>
                    <div>
                        <div class="bg-gray-100 rounded-2xl px-4 py-3 text-gray-800">{{ $welcomeMessage }}</div>
                        <div class="text-xs text-gray-500 mt-1 text-right">{{ now()->format('h:i A') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Input Area -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <div class="max-w-3xl mx-auto">
                    <div class="relative flex items-center bg-gray-100 rounded-full px-4">
                        <input 
                            type="text" 
                            id="message" 
                            placeholder="Type your financial message..." 
                            class="flex-1 bg-transparent py-3 outline-none text-gray-800 placeholder-gray-500"
                            autocomplete="off"
                        />
                        <button id="send-btn" class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center ml-2 hover:bg-purple-700 transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div class="text-xs text-gray-500 text-center mt-2">
                        AI may produce inaccurate information. Verify important details.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>