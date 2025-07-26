<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIController extends Controller
{
    public function chat(Request $request)
    {
        $text = $request->input('message');

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo', // hoặc gpt-4 nếu bạn có quyền
                'messages' => [
                    ['role' => 'user', 'content' => $text],
                ],
            ]);

            $reply = $result->choices[0]->message->content ?? 'Không có phản hồi.';

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Lỗi từ OpenAI: ' . $e->getMessage()
            ], 500);
        }
    }
}
