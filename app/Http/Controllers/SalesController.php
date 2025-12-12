<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // Show all sales history
    public function index()
    {
        $sales = Sale::with('user', 'saleDetails.product')
            ->orderBy('sale_date', 'desc')
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    // Show sale details
    public function show(Sale $sale)
    {
        $sale->load('user', 'saleDetails.product');
        return view('sales.show', compact('sale'));
    }

    // Download receipt
    public function downloadReceipt(Sale $sale)
    {
        $sale->load('saleDetails.product', 'user');
        return view('sales.receipt-pdf', compact('sale'));
    }

    // Filter sales by date
    public function filter(Request $request)
    {
        $query = Sale::query();

        if ($request->filled('start_date')) {
            $query->whereDate('sale_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('sale_date', '<=', $request->end_date);
        }

        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', 'like', '%' . $request->invoice_number . '%');
        }

        $sales = $query->with('user', 'saleDetails.product')
            ->orderBy('sale_date', 'desc')
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }
}
