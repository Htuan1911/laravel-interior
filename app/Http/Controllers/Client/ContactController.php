<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('client.Contac.contact');
    }

   public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // Truyền biến cho view mail, đổi tên 'message' thành 'user_message' để tránh trùng tên biến
        Mail::send('emails.contact', [
            'name' => $data['name'],
            'email' => $data['email'],
            'user_message' => $data['message'],
        ], function ($message) use ($data) {
<<<<<<< HEAD
            $message->to('phamngocan2k5@gmail.com', 'Admin')
=======
            $message->to('tuandhph51200@gmail.com', 'Admin')
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
                    ->subject('Tin nhắn liên hệ từ website')
                    ->replyTo($data['email']);
        });

        return back()->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!');
    }
}


