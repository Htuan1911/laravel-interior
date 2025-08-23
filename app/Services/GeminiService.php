<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GeminiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 15.0,
        ]);
    }

    public function compareProducts(array $products): string
    {
        $content = "Bạn là một chuyên gia phân tích sản phẩm nội thất. Hãy dựa trên các thông số kỹ thuật để so sánh chi tiết từng sản phẩm, chỉ ra rõ ưu điểm và hạn chế của mỗi sản phẩm. Sau đó, đưa ra lời khuyên ngắn gọn (khoảng 2-3 câu) về sản phẩm nào phù hợp nhất cho khách hàng phổ thông. Hãy giải thích lý do nên chọn sản phẩm đó dựa trên các lợi ích nổi bật và sự khác biệt so với sản phẩm còn lại. Không đề cập đến ID sản phẩm trong câu trả lời."
        . json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        try {
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY');

            $response = $this->client->post($url, [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $content]
                            ]
                        ]
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'AI không trả về kết quả.';
        } catch (Exception $e) {
            return 'Lỗi khi gọi Gemini: ' . $e->getMessage();
        }
    }
}
