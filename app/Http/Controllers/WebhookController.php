<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function xendit(Request $request)
    {
        // Verifikasi token — pastikan request benar-benar dari Xendit
        $token = $request->header('x-callback-token');

        if ($token !== config('services.xendit.webhook_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->all();

        // Pastikan data yang dikirim Xendit lengkap
        if (!isset($data['external_id']) || !isset($data['status'])) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Cari order berdasarkan order_number
        $order = Order::where('order_number', $data['external_id'])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $payment = Payment::where('order_id', $order->id)->first();

        // Update status berdasarkan notifikasi dari Xendit
        if ($data['status'] === 'PAID') {
            $order->update(['status' => 'paid']);

            if ($payment) {
                $payment->update([
                    'status'         => 'paid',
                    'payment_method' => $data['payment_channel'] ?? null,
                    'paid_at'        => now(),
                ]);
            }
        } elseif ($data['status'] === 'EXPIRED') {
            $order->update(['status' => 'cancelled']);

            if ($payment) {
                $payment->update(['status' => 'expired']);
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}