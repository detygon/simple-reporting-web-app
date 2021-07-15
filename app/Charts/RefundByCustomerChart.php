<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Services\RefundService;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class RefundByCustomerChart extends BaseChart
{
    private RefundService $refundService;

    public function __construct(RefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = $this->refundService->byCustomers()->limit(10)->get();
        $labels = $data->map(fn ($item) => $item->user_name);
        $series = $data->map(fn ($item) => (float) $item->total_refund);

        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Total Refund', $series->toArray());
    }
}
