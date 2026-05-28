<?php

namespace App\Http\Controllers;

use App\Models\PcPart;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::count();
        $totalParts    = PcPart::count();
        $myParts       = PcPart::where('user_id', auth()->id())->count();

        $categoryData  = PcPart::selectRaw('category, count(*) as total')
                            ->groupBy('category')->pluck('total', 'category');

        $monthlyData   = PcPart::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('month')->orderBy('month')
                            ->pluck('total', 'month');

        return view('dashboard', compact('totalUsers', 'totalParts', 'myParts', 'categoryData', 'monthlyData'));
    }
}
