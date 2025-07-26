<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function chatAI(Request $request)
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4', // hoặc gpt-3.5-turbo nếu bạn dùng gói thấp hơn
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là một nhân viên hỗ trợ khách hàng thân thiện.'],
                ['role' => 'user', 'content' => $request->input('message')],
            ],
        ]);

        return response()->json([
            'reply' => $response->choices[0]->message->content,
        ]);
    }

    public function predefined()
    {
        return response()->json([
            ['question' => 'Làm sao để đổi trả sản phẩm?', 'answer' => 'Bạn có thể đổi trả trong vòng 30 ngày...'],
            ['question' => 'Thời gian giao hàng là bao lâu?', 'answer' => 'Thông thường từ 3-5 ngày làm việc...'],
            // Thêm các câu mẫu khác
        ]);
    }
        public function index()
    {
        return view('client.chatbot.index');
    }

    public function ask(Request $request)
{
    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $request->input('message')],
            ],
        ]);

        return response()->json([
            'answer' => $response->choices[0]->message->content ?? 'Không có phản hồi.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'answer' => 'Có lỗi xảy ra: ' . $e->getMessage(),
        ], 500);
    }
}

    public function quick(Request $request)
    {
        $question = $request->input('question');
        $answers = [
            'Vận Chuyển' => 'Chúng tôi giao hàng toàn quốc trong vòng 3-5 ngày.',
            'Đổi trả' => 'Bạn có thể đổi trả trong vòng 30 ngày kể từ ngày nhận hàng.',
            'Hỗ trợ' => 'Bạn có thể liên hệ 24/7 qua số hotline 0123 456 789.',
            'Thanh Toán' => 'Chúng tôi hỗ trợ thanh toán qua Momo, ZaloPay, ATM, Visa.',
            'Khuyễn mãi' => 'Hiện có chương trình giảm giá 10% cho đơn trên 1 triệu.',
            'Kích Thước Sản Phẩm' => 'Thông tin kích thước có trong phần chi tiết mỗi sản phẩm.',
        ];

        return response()->json(['answer' => $answers[$question] ?? 'Câu hỏi không tồn tại.']);
    }
}