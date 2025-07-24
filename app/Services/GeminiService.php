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
        $content = "Bạn là chuyên gia phân tích sản phẩm nội thất.
        sản phẩm sau dựa trên các thông số kỹ thuật. Hãy phân tích ưu nhược điểm từng sản phẩm và đưa ra lời khuyên ngắn gọn khoảng 2-3 câu nên mua sản phẩm nào phù hợp nhất cho khách hàng phổ thông, nên mua sản phẩm này vì điều gì. Không đề cập đến ID sản phẩm trong câu trả lời. \n\n"
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
