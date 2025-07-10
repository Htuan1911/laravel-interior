<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    public function showForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['otp' => 'Không tìm thấy người dùng.']);
        }

        if ($user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'is_verified' => true,
        ]);

        Auth::login($user);

        return $user->role_id == 1
            ? redirect()->route('admin.dashboard')
            : redirect()->route('client.home');
    }
}
