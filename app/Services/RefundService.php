<?php


namespace App\Services;


use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class RefundService
{
    public function byCustomers(): Builder
    {
        return Order::join('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.is_refunded', 1)
            ->groupBy('users.id')
            ->orderBy('total_refund', 'DESC')
            ->selectRaw('
                users.id AS user_id,
                users.name AS user_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) AS total_refund
            ');
    }

    public function byProducts(): Builder
    {
        return Order::join('products', 'products.id', '=', 'orders.product_id')
            ->where('orders.is_refunded', 1)
            ->groupBy('products.id')
            ->orderBy('total_refund', 'DESC')
            ->selectRaw('
                products.id AS product_id,
                products.name AS product_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) AS total_refund
            ');
    }

    public function total(): float
    {
        $result = Order::where('is_refunded', 1)
            ->selectRaw('SUM(total_amount) AS total_refund')
            ->first();

        return $result->total_refund;
    }
}
