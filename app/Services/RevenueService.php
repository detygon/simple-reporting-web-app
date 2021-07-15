<?php


namespace App\Services;


use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class RevenueService
{
    public function netRevenue(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('SUM(total_amount) - SUM(fees) AS net_revenue')
            ->first();

        return $result->net_revenue;
    }

    public function byCustomers(): Builder
    {
        return Order::join('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.is_refunded', 0)
            ->groupBy('users.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                users.id AS user_id,
                users.name AS user_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) - SUM(orders.fees) AS net_revenue
            ');
    }

    public function byProducts(): Builder
    {
        return Order::join('products', 'products.id', '=', 'orders.product_id')
            ->where('orders.is_refunded', 0)
            ->groupBy('products.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                products.id AS product_id,
                products.name AS product_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) - SUM(orders.fees) AS net_revenue
            ');
    }
}
