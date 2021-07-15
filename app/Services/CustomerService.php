<?php


namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CustomerService
{
    public function count(): int
    {
        return User::count();
    }

    public function latest(): Builder
    {
        return User::latest();
    }

    public function averageNetRevenue(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('SUM(total_amount)/COUNT(DISTINCT user_id) AS average_revenue')
            ->first();

        return $result->average_revenue;
    }

    public function highestSpender(): array
    {
        $result = Order::join('users', 'orders.user_id', 'users.id')
            ->where('is_refunded', 0)
            ->groupBy('users.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                users.name AS name,
                SUM(orders.total_amount) AS gross_revenue,
                SUM(orders.fees) AS total_fees,
                SUM(orders.total_amount) - SUM(orders.fees) AS net_revenue
            ')
            ->first();

        return [
            'name' => $result->name,
            'netRevenue' => $result->net_revenue
        ];
    }

    public function payingCustomers(): float
    {
        $result = Order::where('is_refunded', 0)
            ->selectRaw('COUNT(DISTINCT user_id) AS paying_customers')
            ->first();

        return $result->paying_customers;
    }

    public function purchaseAndRefunds(): Builder
    {
        return Order::join('users', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id')
            ->orderBy('net_revenue', 'DESC')
            ->selectRaw('
                users.id AS user_id,
                users.name AS user_name,
                COUNT(orders.id) AS total_orders,
                SUM(orders.total_amount) AS gross_revenue,
                SUM(CASE WHEN orders.is_refunded = 1 THEN 1 ELSE 0 END) AS refunded_orders,
                SUM(CASE WHEN orders.is_refunded = 1 THEN orders.total_amount ELSE 0 END) AS refunded_amount,
                SUM(orders.fees) AS total_fees,
                SUM(orders.total_amount) - SUM(CASE WHEN orders.is_refunded = 1 THEN orders.total_amount ELSE 0 END) - SUM(orders.fees) AS net_revenue
            ');
    }

    public function latestCustomers(): array
    {
        return User::latest()->limit(10);
    }
}
