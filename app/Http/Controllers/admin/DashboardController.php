<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use App\Models\CarLoan;
use App\Models\Company;
use App\Models\Insurance;
use App\Models\MortageLoan;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = AdminLogin::where('role_id', '<>', 1)->count();
        $purchase = Purchase::count();
        $sales = Sale::count();
        $carloan = CarLoan::count();
        $mortageLoan = MortageLoan::count();
        $insurances = Insurance::where('insurance_id', 3)->orderBy('created_at', 'desc')->take(10)->get();
        $executive = Insurance::with('executive')->get();
        $company = Insurance::with('company')->get();
        return view('admin.dashboard', compact('userCount', 'purchase', 'sales', 'carloan', 'mortageLoan', 'insurances','executive','company'));
    }
}
