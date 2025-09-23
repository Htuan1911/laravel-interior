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
    sleep(1); // Thêm độ trễ nếu cần

    // Prompt của bạn
    $prompt = "Bạn là một chuyên gia nội thất. "
    . "Hãy so sánh các sản phẩm dưới đây một cách ngắn gọn, súc tích, dễ hiểu cho khách hàng phổ thông.\n\n"
    . "- Chỉ nêu 3 điểm khác biệt chính giữa các sản phẩm.\n"
    . "- Giải thích sản phẩm nào phù hợp nhất và tại sao (2-3 câu).\n"
    . "- Không liệt kê quá nhiều thông số kỹ thuật.\n"
    . "- Ưu tiên nêu lợi ích thực tế cho người dùng (ví dụ: tiết kiệm không gian, thoải mái, dễ vệ sinh, phù hợp ngân sách).\n\n"
    . "Danh sách sản phẩm:\n"
        . json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    try {
        $url = 'https://api.cohere.ai/v2/chat';

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'command-a-03-2025', // hoặc model mới nào được hỗ trợ
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Bạn là một trợ lý AI giúp so sánh sản phẩm nội thất một cách chuyên sâu và dễ hiểu.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        // Response từ Cohere Chat API thường nằm ở key 'text'
         return $result['message']['content'][0]['text'] ?? 'AI không trả về kết quả.';
    } catch (\Exception $e) {
        return 'Lỗi khi gọi Cohere Chat API: ' . $e->getMessage();
    }
}

}