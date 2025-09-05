<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardDataService;
use App\Services\ProductAvailabilityService;
use App\Models\ProductType;

class DashboardController extends Controller
{
    public function index() {
        

        return view('dashboard');
    }
}
