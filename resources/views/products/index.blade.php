@extends('layouts.app')

@section('title', 'Products Inventory')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold">Product Inventory</h1>
    <a href="{{ route('products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
        ➕ Add Product
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Image</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Code</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Category</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Stock</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3">
                    @if($product->product_image)
                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="h-10 w-10 object-cover rounded">
                    @else
                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                    @endif
                </td>
                <td class="px-6 py-3 text-sm font-mono">{{ $product->product_code }}</td>
                <td class="px-6 py-3 text-sm">{{ $product->product_name }}</td>
                <td class="px-6 py-3 text-sm">{{ $product->product_category }}</td>
                <td class="px-6 py-3 text-sm font-semibold">₱{{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-3 text-sm">
                    <span class="font-semibold">{{ $product->stock_quantity }}</span>
                </td>
                <td class="px-6 py-3 text-sm">
                    @if($product->isLowStock())
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs">⚠️ Low Stock</span>
                    @else
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">✓ Available</span>
                    @endif
                </td>
                <td class="px-6 py-3 text-center text-sm">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-3">✎ Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-500">No products found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div class="mt-6 flex justify-center">
    {{ $products->links() }}
</div>
@endif
@endsection
