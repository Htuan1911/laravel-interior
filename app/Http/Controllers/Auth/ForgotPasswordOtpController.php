<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\OtpMail;

class ForgotPasswordOtpController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password-otp-email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));
        session(['reset_password_email' => $user->email]);

        return redirect()->route('password.otp.verify.form')->with('status', 'Mã OTP đã được gửi tới email.');
    }

    public function showOtpForm()
    {
        return view('auth.forgot-password-otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.otp.email.form')->withErrors(['email' => 'Không tìm thấy email']);
        }

        $user = User::where('email', $email)->first();

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn']);
        }

        // Xóa OTP để tránh dùng lại
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Cho phép đặt lại mật khẩu
        session(['allow_password_reset' => true]);

        return redirect()->route('password.otp.reset.form');
    }

    public function showResetForm()
    {
        if (!session('allow_password_reset')) {
            return redirect()->route('password.otp.email.form');
        }

        return view('auth.forgot-password-otp-reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = session('reset_password_email');
        $user = User::where('email', $email)->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget(['reset_password_email', 'allow_password_reset']);

        return redirect()->route('login')->with('status', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
    }
}
