<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Gemini\Client;
use Gemini\Data\Content;
use Gemini\Enums\Role;

class ChatController extends Controller
{
    protected Client $geminiClient;

    public function __construct(Client $geminiClient)
    {
        $this->geminiClient = $geminiClient;
    }

    /**
     * Handle user chat request with history and proxy it to Gemini API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:2000',
            'history' => 'present|array',
            'history.*.role' => ['required', Rule::in(['user', 'bot'])],
            'history.*.text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $userMessage = $request->input('message');
            $history = $request->input('history', []);

            // The system prompt is now part of the history, sent only once by the client
            $historyForGemini = $this->buildHistoryForGemini($history);

            // Start a chat session with the existing history
            $chat = $this->geminiClient->geminiPro()->startChat($historyForGemini);
            
            // Send the new message
            $response = $chat->sendMessage($userMessage);

            return response()->json([
                'reply' => $response->text()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while communicating with the AI service.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Converts the history from the client-side format to the Gemini PHP client format.
     *
     * @param array $history
     * @return array
     */
    private function buildHistoryForGemini(array $history): array
    {
        $geminiHistory = [];
        foreach ($history as $message) {
            // The Gemini client uses 'model' for the bot's role.
            $role = $message['role'] === 'bot' ? Role::MODEL : Role::USER;
            $geminiHistory[] = Content::parse(['role' => $role->value, 'parts' => [['text' => $message['text']]]]);
        }
        return $geminiHistory;
    }
}