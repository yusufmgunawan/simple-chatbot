<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class ChatController extends Controller
{
    public function index(){

        session()->forget('chat_history');

        $welcomePrompt = "give user a warm welcome message, and ask how can I assist you today? just reply with the welcome message, no other text, no code block, no markdown, no html tags, just the message and add some emojis to make it more friendly 😊";

        $response = Prism::text()
            ->using(Provider::Groq, 'llama3-70b-8192')
            ->usingProviderConfig([
                'url' => 'https://api.groq.com/openai/v1',
                'api_key' => env('GROQ_API_KEY'),
            ])
            ->withPrompt($welcomePrompt)
            ->asText();

        $welcomeMessage = $response->responseMessages->first()->content ?? 'Hello! How can I assist you today?';
        return view('chat', ['welcomeMessage' => $welcomeMessage]);
    }

    public function send(Request $request){
        
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = $request->input('message');

        $chatHistory = session('chat_history', []);

        $chatHistory[] = ['role' => 'user', 'content' => $userMessage];

        $conversationPrompt = '';
        foreach ($chatHistory as $msg) {
            $roleLabel = $msg['role'] === 'user' ? 'User' : 'Assistant';
            $conversationPrompt .= "{$roleLabel}: {$msg['content']}\n";
        }

        $conversationPrompt .= "Assistant:";

        $response = Prism::text()
            ->using(Provider::Groq, 'llama3-70b-8192')
            ->usingProviderConfig([
                'url' => 'https://api.groq.com/openai/v1',
                'api_key' => env('GROQ_API_KEY'),
            ])
            ->withPrompt($conversationPrompt)
            ->asText();

        $botMessage = $response->responseMessages->first()->content ?? 'Sorry, I could not process your request.';

        $chatHistory[] = ['role' => 'assistant', 'content' => $botMessage];
        session(['chat_history' => $chatHistory]);

        return response()->json(['reply' => $botMessage]);
    }

}
