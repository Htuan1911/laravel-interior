<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
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
=======
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Exception;

class ChatbotController extends Controller
{
    // Danh sách stop words mở rộng
    private $stopWords = [
        // Giao tiếp
        'xin', 'chào', 'hi', 'hello', 'alo', 'này', 'ơi',
        // Đại từ nhân xưng
        'tôi', 'mình', 'em', 'anh', 'chị', 'bạn', 'chúng', 'ta', 'mày', 'cậu',
        // Động từ chung chung
        'tìm', 'tìm kiếm', 'cho', 'giúp', 'xem', 'có', 'muốn', 'cần', 'xài', 'dùng', 'mua', 'bán', 'thấy',
        // Cụm từ thường gặp
        'các', 'loại', 'kiểu', 'dạng', 'nào', 'gì', 'được', 'không', 'ko', 'kg', 'hông', 'hok', 'đi', 'thử',
        'shop', 'cửa hàng', 'bên', 'ở', 'nơi', 'này', 'đó', 'kia', 'đâu', 'vậy', 'ạ', 'nhé', 'nhỉ', 'ha', 'hả'
    ];

    // Hàm lọc từ khóa
    private function extractKeyword($message)
    {
        // Chuẩn hóa chữ thường, bỏ dấu câu
        $message = mb_strtolower($message, 'UTF-8');
        $message = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $message); // chỉ giữ chữ & số
        $message = preg_replace('/\s+/', ' ', $message);

        // Loại bỏ stop words
        $words = explode(' ', $message);
        $keywords = array_diff($words, $this->stopWords);

        return trim(implode(' ', $keywords));
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    }

    public function sendMessage(Request $request)
    {
<<<<<<< HEAD
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
=======
        $languageCode = 'vi';
        $message = trim($request->input('message'));
        $keywordString = $this->extractKeyword($message);

        // Query sản phẩm
        $query = DB::table('products')
            ->join('product_translations', function ($join) use ($languageCode) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.language_code', '=', $languageCode);
            })
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->whereNull('products.deleted_at')
            ->select(
                'products.id',
                'product_translations.name',
                DB::raw('GROUP_CONCAT(DISTINCT product_variants.variant_name SEPARATOR ", ") as variants'),
                DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices'),
                DB::raw('GROUP_CONCAT(DISTINCT product_variants.stock_quantity ORDER BY product_variants.price SEPARATOR ", ") as stocks')
            )
            ->groupBy('products.id', 'product_translations.name');

        // Nếu có từ khóa thì tìm kiếm
        if (!empty($keywordString)) {
            $query->where(function ($q) use ($keywordString) {
                $q->where('product_translations.name', 'like', "%{$keywordString}%")
                  ->orWhere('product_translations.description', 'like', "%{$keywordString}%")
                  ->orWhere('product_variants.variant_name', 'like', "%{$keywordString}%");
            });
        }

        $products = $query->limit(10)->get();

        // Nếu không tìm thấy → fallback gợi ý sản phẩm rẻ nhất
        if ($products->isEmpty()) {
            $products = DB::table('products')
                ->join('product_translations', function ($join) use ($languageCode) {
                    $join->on('products.id', '=', 'product_translations.product_id')
                        ->where('product_translations.language_code', '=', $languageCode);
                })
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->whereNull('products.deleted_at')
                ->select(
                    'products.id',
                    'product_translations.name',
                    DB::raw('GROUP_CONCAT(DISTINCT product_variants.variant_name SEPARATOR ", ") as variants'),
                    DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices'),
                    DB::raw('GROUP_CONCAT(DISTINCT product_variants.stock_quantity ORDER BY product_variants.price SEPARATOR ", ") as stocks')
                )
                ->groupBy('products.id', 'product_translations.name')
                ->orderBy(DB::raw('MIN(product_variants.price)'), 'asc')
                ->limit(5)
                ->get();
        }

        // Chuẩn bị context cho AI
        if ($products->isEmpty()) {
            $context = "Hiện tại shop chưa có sản phẩm phù hợp, bạn vui lòng liên hệ hotline 0123.456.789 để được hỗ trợ.";
        } else {
            $context = "Danh sách sản phẩm:\n";
            foreach ($products as $p) {
                $context .= "- {$p->name}\n";
                $context .= "  Biến thể: {$p->variants}\n";
                $context .= "  Giá: {$p->prices} VND\n";
                $context .= "  Tồn kho: {$p->stocks}\n\n";
            }
        }

        // Prompt AI
        $prompt = "Bạn là trợ lý bán hàng của Style House.
Trả lời ngắn gọn, dễ hiểu, dựa trên danh sách sản phẩm bên dưới.
Nếu không có sản phẩm thì trả lời nguyên văn: 'Hiện tại shop chưa có sản phẩm phù hợp, bạn vui lòng liên hệ hotline 0123.456.789 để được hỗ trợ.'

{$context}

Câu hỏi của khách: {$message}";

        // Gọi Gemini API
       // Gọi Gemini API với retry & fallback
try {
    $client = new Client();
    $maxRetries = 3;
    $delaySeconds = 2;
    $reply = null;

    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $response = $client->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
                [
                    'query' => ['key' => env('GEMINI_API_KEY')],
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ]
                    ],
                    'timeout' => 30,
                ]
            );

            $data = json_decode($response->getBody(), true);
            $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!empty($reply)) {
                break; // Thành công → dừng retry
            }
        } catch (Exception $e) {
            if ($i < $maxRetries - 1) {
                sleep($delaySeconds); // Chờ rồi thử lại
                continue;
            } else {
                throw $e; // Hết lượt thử → quăng lỗi
            }
        }
    }

    // Nếu AI không trả lời được → fallback
   // Nếu AI không trả lời được → fallback
if (empty($reply)) {
    if ($products->isEmpty()) {
        $reply = "Hiện tại shop chưa có sản phẩm phù hợp, bạn vui lòng liên hệ hotline 0123.456.789 để được hỗ trợ.";
    } else {
        $reply = "Hiện tại hệ thống AI đang bận, dưới đây là danh sách sản phẩm:\n";
        foreach ($products as $p) {
            $reply .= "- {$p->name}\n";
            $reply .= "  Biến thể: {$p->variants}\n";
            $reply .= "  Giá: {$p->prices} VND\n";
            $reply .= "  Tồn kho: {$p->stocks}\n\n";
        }
    }
}   


    return response()->json(['reply' => $reply], 200);

} catch (Exception $e) {
    // Lỗi API hoặc server
    $fallbackReply = $products->isEmpty()
        ? "Hiện tại shop chưa có sản phẩm phù hợp, bạn vui lòng liên hệ hotline 0123.456.789 để được hỗ trợ."
        : "Hiện tại hệ thống AI đang bận, dưới đây là danh sách sản phẩm:\n" . $context;

    return response()->json(['reply' => $fallbackReply], 200);
}

}}
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
