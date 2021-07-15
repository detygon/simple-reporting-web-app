<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Services\RevenueService;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class NetRevenueByProductChart extends BaseChart
{
    /**
     * @var RevenueService
     */
    private $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = $this->revenueService->byProducts()->limit(10)->get();
        $labels = $data->map(fn ($item) => $item->product_name);
        $series = $data->map(fn ($item) => (float) $item->net_revenue);

        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Net Revenue', $series->toArray());
    }
}
