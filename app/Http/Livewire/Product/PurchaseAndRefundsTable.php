<?php

namespace App\Http\Livewire\Product;

use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PurchaseAndRefundsTable extends DataTableComponent
{
    public function columns(): array
    {
        return [
            Column::make('Product Id')->sortable()->searchable(),
            Column::make('Product Name')->sortable()->searchable(),
            Column::make('Total Orders')->sortable(),
            Column::make('Gross Revenue')->sortable(),
            Column::make('Refunded Orders')->sortable(),
            Column::make('Refunded Amount')->sortable(),
            Column::make('Total Fees')->sortable(),
            Column::make('Net Revenue')->sortable(),
        ];
    }

    public function query(): Builder
    {
        return app(ProductService::class)->purchaseAndRefunds();
    }
}
