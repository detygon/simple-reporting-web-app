<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Film;
use App\Models\Rental;
use App\Models\Staff;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(CustomerService $customerService, OrderService $orderService, ProductService $productService)
    {
        return view('dashboard', [
            'totalCustomers' => $customerService->count(),
            'totalProducts' => $productService->count(),
            'totalOrders' => $orderService->count(),
        ]);
    }
}
