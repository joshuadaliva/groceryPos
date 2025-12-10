<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::paginate(15);
        return view('products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        return view('products.create');
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products',
            'product_name' => 'required|string|max:250',
            'product_category' => 'required|string|max:45',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
                       ->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'product_name' => 'required|string|max:250',
            'product_category' => 'required|string|max:45',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
                       ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                       ->with('success', 'Product deleted successfully!');
    }

    // Search products (AJAX)
    public function search(Request $request)
    {
        $search = $request->input('q');
        
        $products = Product::where('product_name', 'like', '%' . $search . '%')
                           ->orWhere('product_code', 'like', '%' . $search . '%')
                           ->where('stock_quantity', '>', 0)
                           ->get();

        return response()->json($products);
    }

    // Get product by barcode/code
    public function getByCode($code)
    {
        $trimmedCode = trim($code);
        $product = Product::where('product_code', $trimmedCode)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
