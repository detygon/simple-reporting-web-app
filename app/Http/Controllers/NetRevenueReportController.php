<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\RevenueService;
use Illuminate\Http\Request;

class NetRevenueReportController extends Controller
{
    public function __invoke(RevenueService $revenueService, OrderService $orderService)
    {
        return view('net-revenue-report', [
            'netRevenue' => '$'.number_format($revenueService->netRevenue()),
            'netOrder' => number_format($orderService->netOrders()),
            'avgNetRevenue' => '$'.number_format($orderService->averageNetRevenue())
        ]);
    }
}
