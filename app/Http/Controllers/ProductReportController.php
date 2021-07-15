<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\RevenueService;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function __invoke(ProductService $productService, OrderService $orderService, RevenueService $revenueService)
    {
        return view('products-report', [
            'totalProducts' => number_format($productService->total()),
            'netRevenue' => '$'.number_format($revenueService->netRevenue()),
            'netOrders' => number_format($orderService->netOrders()),
            'avgNetRevenue' => '$'.number_format($productService->averageNetRevenue()),
            'bestSeller' => $productService->bestSeller()
        ]);
    }
}
