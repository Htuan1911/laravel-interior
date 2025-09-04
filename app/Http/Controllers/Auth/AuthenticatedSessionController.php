<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // Thử đăng nhập với email và password
 if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
    $request->session()->regenerate();

    $user = Auth::user();

    // Kiểm tra trạng thái tài khoản
    if ($user->status !== 'active') {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Tài khoản của bạn chưa được kích hoạt hoặc đã bị khóa.',
        ]);
    }

    // Nếu vẫn còn mã OTP chưa xác minh
    if (!is_null($user->otp)) {
        Auth::logout(); // Đăng xuất nếu chưa xác minh

        // Lưu email vào session để xác minh OTP
        session(['email' => $user->email]);

        return redirect()->route('verify.otp.form')
            ->withErrors(['otp' => 'Tài khoản chưa được xác minh. Vui lòng nhập mã OTP được gửi tới email.']);
    }

    // Chuyển hướng sau đăng nhập thành công theo vai trò
    return $user->role_id == 1
        ? redirect()->route('admin.dashboard')
        : redirect()->route('client.home');
}

    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
         return redirect()->route('client.home');

        // return redirect('/');
    }
}
