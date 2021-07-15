<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffSalesByYearChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = collect(DB::select('
            SELECT staff.staff_id, first_name, last_name, ROUND(SUM(amount), 2) as total
            FROM staff
            JOIN payment
            ON staff.staff_id = payment.staff_id
            WHERE YEAR(payment_date) = ?
            GROUP BY payment.staff_id;
        ', [$request->get('year', 2005)]));

        $labels = $data->map(function ($item) {
            return $item->first_name . " " .$item->last_name;
        });

        $series = $data->map(function ($item) {
            return $item->total;
        });

        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Ventes', $series->toArray());
    }
}
