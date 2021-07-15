<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopCategoryByRevenueChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $data = collect(DB::select('
            select cat.name category_name, round(sum(IFNULL(pay.amount, 0)), 2) revenue
            from category cat
                     left join film_category flm_cat
                               on cat.category_id = flm_cat.category_id
                     left join film fil
                               on flm_cat.film_id = fil.film_id
                     left join inventory inv
                               on fil.film_id = inv.film_id
                     left join rental ren
                               on inv.inventory_id = ren.inventory_id
                     left join payment pay
                               on ren.rental_id = pay.rental_id
            where YEAR(pay.payment_date) = ?
            group by cat.name
            order by revenue desc
            limit 5;
        ', [$request->get('year', 2005)]));

        $labels = $data->map(function ($item) {
            return $item->category_name;
        });

        $series = $data->map(function ($item) {
            return $item->revenue;
        });

        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('pie', $series->toArray());
    }
}
