<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current month data
        $currentMonth = Carbon::now();
        
        $totalSales = Sale::whereMonth('sale_date', $currentMonth->month)
                          ->whereYear('sale_date', $currentMonth->year)
                          ->sum('total_amount');
        
        $totalTransactions = Sale::whereMonth('sale_date', $currentMonth->month)
                                 ->whereYear('sale_date', $currentMonth->year)
                                 ->count();
        
        $totalProducts = Product::count();
        
        $lowStockProducts = Product::where('stock_quantity', '<', 5)->count();
        
        // Top selling products
        $topProducts = Product::whereHas('salesDetails')
            ->withCount(['salesDetails as total_sold' => function($query) {
                $currentMonth = Carbon::now();
                $query->whereMonth('created_at', $currentMonth->month)
                      ->whereYear('created_at', $currentMonth->year);
            }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Sales trend (last 7 days)
        $salesTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $salesTrend[] = [
                'date' => $date->format('M d'),
                'amount' => $sales,
            ];
        }

        return view('dashboard', compact(
            'totalSales',
            'totalTransactions',
            'totalProducts',
            'lowStockProducts',
            'topProducts',
            'salesTrend'
        ));
    }
}
