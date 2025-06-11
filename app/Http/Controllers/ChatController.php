<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class ChatController extends Controller
{
    public function index(){
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

        $response = Prism::text()
            ->using(Provider::Groq, 'llama3-70b-8192')
            ->usingProviderConfig([
                'url' => 'https://api.groq.com/openai/v1',
                'api_key' => env('GROQ_API_KEY'),
            ])
            ->withPrompt($userMessage)
            ->asText();

        $botMessage = $response->responseMessages->first()->content ?? 'Sorry, I could not process your request.';

        return response()->json(['reply' => $botMessage]);
    }
}
