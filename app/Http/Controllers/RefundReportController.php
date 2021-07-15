<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundReportController extends Controller
{
    public function __invoke(RefundService $refundService, OrderService $orderService)
    {
        return view('refunds-report', [
            'totalRefunds' => number_format($refundService->total()),
            'totalOrders' => number_format($orderService->refunded()),
            'avgOrderRefund' => '$'.number_format($orderService->averageRefund())
        ]);
    }
}
