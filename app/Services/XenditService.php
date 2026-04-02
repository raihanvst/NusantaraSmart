<?php

namespace App\Services;

use App\Models\Order;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class XenditService
{
    protected InvoiceApi $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
        $this->invoiceApi = new InvoiceApi();
    }

    public function createInvoice(Order $order): array
    {
        $params = new CreateInvoiceRequest([
            'external_id'          => $order->order_number,
            'amount'               => (int) $order->total_amount,
            'payer_email'          => $order->user->email,
            'description'          => 'Pembayaran Order ' . $order->order_number . ' - NusantaraSmart',
            'success_redirect_url' => route('orders.show', $order),
            'failure_redirect_url' => route('orders.show', $order),
        ]);

        $response = $this->invoiceApi->createInvoice($params);

        return [
            'invoice_id'  => $response->getId(),
            'invoice_url' => $response->getInvoiceUrl(),
        ];
    }
}