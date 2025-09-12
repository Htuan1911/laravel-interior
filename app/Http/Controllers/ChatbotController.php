<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    }

    public function chatOpenAI(Request $request)
    {
        $message = $request->input('message');

        try {
            $client = new Client();

            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini', // bạn có thể đổi sang 'gpt-4o' nếu muốn
                    'messages' => [
                        ['role' => 'system', 'content' => 'Bạn là trợ lý bán hàng của website Nội Thất Style House.'],
                        ['role' => 'user', 'content' => $message],
                    ],
                ],
                'timeout' => 20, // tránh treo request
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'reply' => $data['choices'][0]['message']['content'] ?? 'Xin lỗi, hiện tại tôi chưa thể trả lời.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi khi gọi OpenAI API: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function sendMessage(Request $request)
    {
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
