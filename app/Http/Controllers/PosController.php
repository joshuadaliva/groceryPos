<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class PosController extends Controller
{
    // Show POS page
    public function index()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('pos.index', compact('products'));
    }

    // Get product details for POS
    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product || $product->stock_quantity <= 0) {
            return response()->json(['error' => 'Product not available'], 404);
        }

        return response()->json($product);
    }

    // Process sale/checkout
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Check if amount paid is enough
        if ($validated['amount_paid'] < $validated['total_amount']) {
            return response()->json([
                'error' => 'Insufficient payment'
            ], 400);
        }

        // Validate stock availability
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock_quantity < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for {$product->product_name}"
                ], 400);
            }
        }

        // Create sale
        $sale = Sale::create([
            'invoice_number' => Sale::generateInvoiceNumber(),
            'user_id' => auth()->id(),
            'total_amount' => $validated['total_amount'],
            'amount_paid' => $validated['amount_paid'],
            'change_amount' => $validated['amount_paid'] - $validated['total_amount'],
            'payment_status' => 'completed',
            'sale_date' => now(),
        ]);

        // Create sale details and update stock
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);

            SalesDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);

            // Deduct stock
            $product->deductStock($item['quantity'], 'SALE-' . $sale->invoice_number);
        }

        return response()->json([
            'success' => true,
            'sale' => $sale,
            'message' => 'Sale completed successfully!'
        ]);
    }

    // Get receipt
    public function receipt($id)
    {
        $sale = Sale::with('saleDetails.product', 'user')->find($id);

        if (!$sale) {
            return redirect()->route('pos.index')->with('error', 'Sale not found');
        }

        return view('pos.receipt', compact('sale'));
    }
}
