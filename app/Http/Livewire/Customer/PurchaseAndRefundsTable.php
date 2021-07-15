<?php

namespace App\Http\Livewire\Customer;

use App\Services\CustomerService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PurchaseAndRefundsTable extends DataTableComponent
{
    public function columns(): array
    {
        return [
            Column::make('User Id')->sortable()->searchable(),
            Column::make('Name', 'user_name')->sortable()->searchable(),
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
        return app(CustomerService::class)->purchaseAndRefunds();
    }
}
