<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\RevenueService;

class CustomerReportController extends Controller
{
    public function __invoke(CustomerService $customerService, RevenueService $revenueService, OrderService $orderService)
    {
        return view('customers-report', [
            'payingCustomers' => number_format($customerService->payingCustomers()),
            'netRevenue' => number_format($revenueService->netRevenue()),
            'netOrders' => number_format($orderService->netOrders()),
            'avgNetRevenue' => number_format($customerService->averageNetRevenue()),
            'highestSpender' => $customerService->highestSpender(),
        ]);
    }
}
