<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    // --- STOP WORDS cho gợi ý sản phẩm ---
    private $stopWords = [
        'cho', 'cần', 'mình', 'tôi', 'muốn', 'tìm', 'kiếm', 'loại', 'sản', 'phẩm',
        'cái', 'này', 'đó', 'nọ', 'với', 'thì', 'là', 'có', 'gì', 'không', 'ở', 'đâu',
        'ra', 'sao', 'thế', 'nào', 'giúp', 'giùm', 'xin', 'vui', 'lòng', 'nhé', 'ạ',
    ];

    // --- Trang giao diện chatbot ---
    public function index()
    {
        return view('chatbot.index');
    }

    // --- Chế độ Chat AI (OpenAI) ---
    public function chatAI(Request $request)
    {
        $message = $request->input('message');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Bạn là trợ lý hỗ trợ khách hàng chuyên nghiệp, trả lời ngắn gọn, thân thiện và rõ ràng.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            return response()->json([
                'reply' => $response->json()['choices'][0]['message']['content'] ?? 'Xin lỗi, hiện tại tôi chưa thể trả lời câu hỏi này.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ask(Request $request)
    {
        $message = $request->input('message');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Bạn là trợ lý hỗ trợ khách hàng thân thiện.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            return response()->json([
                'reply' => $response->json()['choices'][0]['message']['content'] ?? 'Xin lỗi, hiện tại tôi chưa thể trả lời câu hỏi này.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Xin lỗi, tôi không thể xử lý câu hỏi ngay bây giờ.',
            ], 500);
        }
    }

    // --- Câu hỏi nhanh (FAQ) ---
    public function predefined()
    {
        return response()->json([
            'questions' => [
                'Làm thế nào để đặt hàng?',
                'Thời gian giao hàng là bao lâu?',
                'Chính sách đổi trả như thế nào?',
                'Sản phẩm có bảo hành không?',
                'Có hỗ trợ khách hàng 24/7 không?',
            ],
            'answers' => [
                'Bạn có thể đặt hàng trực tiếp qua website bằng cách chọn sản phẩm và nhấn "Mua ngay" hoặc "Thêm vào giỏ hàng".',
                'Thời gian giao hàng thường từ 2-5 ngày làm việc tùy khu vực.',
                'Chính sách đổi trả áp dụng trong vòng 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất.',
                'Hầu hết sản phẩm đều có bảo hành từ 6-12 tháng tùy loại.',
                'Chúng tôi hỗ trợ khách hàng 24/7 qua chatbot và hotline.',
            ],
        ]);
    }

    public function quick(Request $request)
    {
        $message = mb_strtolower(trim($request->input('message')));
        $faq = [
            'đặt hàng' => 'Bạn có thể đặt hàng qua website bằng cách chọn sản phẩm và nhấn "Mua ngay".',
            'giao hàng' => 'Thời gian giao hàng thường từ 2-5 ngày làm việc tùy khu vực.',
            'đổi trả' => 'Chính sách đổi trả trong vòng 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất.',
            'bảo hành' => 'Hầu hết sản phẩm đều có bảo hành từ 6-12 tháng tùy loại.',
            'hỗ trợ' => 'Chúng tôi hỗ trợ khách hàng 24/7 qua chatbot và hotline.',
        ];

        foreach ($faq as $keyword => $answer) {
            if (str_contains($message, $keyword)) {
                return response()->json(['reply' => $answer]);
            }
        }

        return response()->json(['reply' => 'Xin lỗi, tôi chưa có thông tin về câu hỏi này.']);
    }

    // --- Chế độ Gợi ý sản phẩm (Gemini + DB) ---
    private function extractKeyword($message)
    {
        $words = preg_split('/\s+/', mb_strtolower($message));
        $filtered = array_filter($words, function ($word) {
            return !in_array($word, $this->stopWords);
        });

        return implode(' ', $filtered);
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $keyword = $this->extractKeyword($userMessage);

        $products = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.name', 'like', "%$keyword%")
            ->select('products.id', 'product_translations.name', 'product_variants.price')
            ->get();

        if ($products->isNotEmpty()) {
            $reply = "Tôi tìm thấy một số sản phẩm liên quan đến '$keyword':\n";
            foreach ($products as $product) {
                $reply .= "- {$product->name} (Giá: " . number_format($product->price, 0, ',', '.') . " VND)\n";
            }
        } else {
            $reply = "Xin lỗi, tôi không tìm thấy sản phẩm nào liên quan đến '$keyword'. Vui lòng liên hệ hotline để được hỗ trợ thêm.";
        }

        return response()->json(['reply' => $reply]);
    }
}
