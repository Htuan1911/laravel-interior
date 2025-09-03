<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'order')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('user', 'order')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::with('user', 'order')->findOrFail($id);
        $statuses = ['pending', 'success', 'failed'];
        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,success,failed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Cập nhật trạng thái thanh toán thành công.');
    }
}
