<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffSalesByMonthChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = $this->getData($request);

        return Chartisan::build()
            ->labels(['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'])
            ->dataset('Magasin 1', array_values($data[1] ?? []))
            ->dataset('Magasin 2', array_values($data[2] ?? []));
    }

    private function getData(Request $request)
    {
        $data = collect(DB::select('
            select staff_id, ROUND(SUM(amount), 2) as total, MONTH(payment_date) as month
            from payment
            where YEAR(payment_date) = ?
            group by staff_id, month;
        ', [$request->get('year', 2005)]));

        return $data->reduce(function ($acc, $current) {
            if (! isset($acc[$current->staff_id])) {
                $acc[$current->staff_id] = $this->defaultValue();
            }

            $acc[$current->staff_id][$current->month] = (float) $current->total;

            return $acc;
        }, []);
    }

    private function defaultValue(): array
    {
        return [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
        ];
    }
}
