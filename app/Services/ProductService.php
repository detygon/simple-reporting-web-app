<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function count(): int
    {
        return Product::count();
    }

    public function averageNetRevenue(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('SUM(total_amount)/COUNT(DISTINCT product_id) AS average_revenue')
            ->first();

        return $result->average_revenue;
    }

    public function bestSeller(): array
    {
        $number = Order::join('products', 'orders.product_id', 'products.id')
            ->where('is_refunded', 0)
            ->groupBy('products.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                products.name AS product_name,
                SUM(orders.total_amount) AS gross_revenue,
                SUM(orders.fees) AS total_fees,
                SUM(orders.total_amount) - SUM(orders.fees) AS net_revenue
            ')
            ->first();

        return [
            'productName' => $number->product_name,
            'netRevenue' => $number->net_revenue
        ];
    }

    public function purchaseAndRefunds(): Builder
    {
        return Order::join('products', 'products.id', '=', 'orders.product_id')
            ->groupBy('products.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                products.id AS product_id,
                products.name AS product_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) AS gross_revenue,
                SUM(CASE WHEN orders.is_refunded = 1 THEN 1 ELSE 0 END) AS refunded_orders,
                SUM(CASE WHEN orders.is_refunded = 1 THEN orders.total_amount ELSE 0 END) AS refunded_amount,
                SUM(orders.fees) AS total_fees,
                SUM(orders.total_amount) - SUM(CASE WHEN orders.is_refunded = 1 THEN orders.total_amount ELSE 0 END) - SUM(orders.fees) AS net_revenue
            ');
    }

    public function total(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('COUNT(DISTINCT product_id) AS total_products')
            ->first();

        return $result->total_products;
    }
}
