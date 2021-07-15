<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Film;
use App\Models\Rental;
use App\Models\Staff;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'totalRentals' => Rental::count(),
            'totalFilms' => Film::count(),
            'totalStaff' => Staff::count(),
            'totalCustomers' => Customer::count(),
        ]);
    }
}
