<?php


namespace App\Services;


use App\Models\Order;

class OrderService
{
    public function count(): int
    {
        return Order::count();
    }

    public function averageNetRevenue(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('SUM(total_amount)/COUNT(id) AS average_revenue')
            ->first();

        return $result->average_revenue;
    }

    public function averageRefund(): float
    {
        $result = Order::where('is_refunded', 1)
            ->selectRaw('SUM(total_amount)/COUNT(id) AS average_revenue')
            ->first();

        return $result->average_revenue;
    }

    public function netOrders(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('COUNT(id) AS net_orders')
            ->first();

        return $result->net_orders;
    }

    public function refunded(): float
    {
        $result = Order::where('is_refunded', 1)
            ->selectRaw('COUNT(id) AS total_order')
            ->first();

        return $result->total_order;
    }
}
