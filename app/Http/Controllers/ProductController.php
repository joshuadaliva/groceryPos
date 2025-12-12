<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hardcoded list of categories for the dropdowns.
    // NOTE: In a production environment, this list should ideally be fetched from a separate 'Categories' table in the database or stored in a config file.
    private $categories = [
        'Beverages',
        'Snacks',
        'Produce',
        'Dairy',
        'Frozen Foods',
        'Household',
        'Canned Goods',
        'Meat',
        'Seafood',
    ];

    // Show all products
    public function index(Request $request)
    {
        $query = Product::query();
        $search = $request->get('q');
        $categoryFilter = $request->get('category');

        // Apply search filter (name or code)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('product_code', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($categoryFilter) {
            $query->where('product_category', $categoryFilter);
        }

        $products = $query->paginate(15)->appends($request->query());

        // Pass categories and filter values to the view
        return view('products.index', [
            'products' => $products,
            'categories' => $this->categories,
            'search' => $search,
            'categoryFilter' => $categoryFilter,
        ]);
    }

    // Show create form
    public function create()
    {
        // Pass categories to the view
        return view('products.create', ['categories' => $this->categories]);
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
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $validated['product_image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        // Pass categories to the view
        return view('products.edit', [
            'product' => $product,
            'categories' => $this->categories,
        ]);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            // NOTE: Changed from 'numeric' to 'string' for product_code, as the placeholder 'PROD-001' is alphanumeric.
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'product_name' => 'required|string|max:250',
            'product_category' => 'required|string|max:45',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $validated['product_image'] = $path;
        }

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

    public function generateBarcodes()
    {
        // Fetch all products, ordered by name for easy reference
        $products = Product::orderBy('product_name')->get();

        return view('products.barcodes', [
            'products' => $products,
        ]);
    }
}