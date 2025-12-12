@extends('layouts.app')

@section('title', 'Products Inventory')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Product Inventory</h1>
            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Manage your store products and stock levels</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Product
            </a>
            <a href="{{ route('products.barcodes') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                View All Barcodes
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-4 transition-colors">
            <p class="text-xs text-gray-600 dark:text-slate-400 mb-1">Total Products</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-slate-50">{{ $products->total() }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-4 transition-colors">
            <p class="text-xs text-gray-600 dark:text-slate-400 mb-1">Available</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $products->where('stock_quantity', '>', 10)->count() }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-4 transition-colors">
            <p class="text-xs text-gray-600 dark:text-slate-400 mb-1">Low Stock</p>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $products->filter(fn($p) => $p->isLowStock())->count() }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-4 transition-colors">
            <p class="text-xs text-gray-600 dark:text-slate-400 mb-1">Categories</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ count($categories) }}</p>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-4 transition-colors">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="flex-1 w-full relative">
                <input type="text"
                    name="q"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by name or code..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors text-sm">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <div class="w-full sm:w-auto">
                <select name="category"
                    class="w-full sm:w-48 px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ ($categoryFilter ?? '') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit"
                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-blue-500 hover:bg-blue-400 text-white shadow-lg shadow-blue-500/40 transition-all duration-200 hover:shadow-blue-500/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0012 15.586V21h-2v-5.414a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
                <a href="{{ route('products.index') }}"
                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-900 dark:text-slate-100 border border-gray-300 dark:border-slate-700/80 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        @foreach($products as $product)
        <div class="group rounded-2xl border p-1 border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-slate-900/20 overflow-hidden transition-all duration-200 hover:shadow-xl hover:shadow-emerald-500/20 dark:hover:shadow-emerald-500/10 hover:-translate-y-1">

            <div class="relative h-30 bg-gray-100 dark:bg-slate-800 overflow-hidden">
                @if($product->product_image)
                <img src="{{ asset('storage/' . $product->product_image) }}"
                    alt="{{ $product->product_name }}"
                    class="w-full h-28 object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-xs text-gray-400 dark:text-slate-500">No Image</p>
                    </div>
                </div>
                @endif

                <div class="absolute top-3 right-3">
                    @if($product->isLowStock())
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/90 text-white backdrop-blur-sm shadow-lg">
                        <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                        Low Stock
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/90 text-white backdrop-blur-sm shadow-lg">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        In Stock
                    </span>
                    @endif
                </div>

                <div class="absolute bottom-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-medium bg-white/90 dark:bg-slate-900/90 text-gray-900 dark:text-slate-100 backdrop-blur-sm shadow-lg">
                        {{ $product->product_code }}
                    </span>
                </div>
            </div>

            <div class="p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-500/30">
                        {{ $product->product_category }}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-slate-400">
                        Stock: <span class="font-semibold text-gray-900 dark:text-slate-100">{{ $product->stock_quantity }}</span>
                    </span>
                </div>

                <h3 class="text-base font-semibold text-gray-900 dark:text-slate-50 line-clamp-2 min-h-[1rem]">
                    {{ $product->product_name }}
                </h3>

                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($product->price, 2) }}</span>
                </div>

                <div class="flex items-center gap-2 pt-3 border-t border-gray-200 dark:border-slate-800">
                    <a href="{{ route('products.edit', $product) }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}"
                        onsubmit="return confirm('Are you sure you want to delete this product?');"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl p-12 text-center">
        <div class="max-w-sm mx-auto">
            <div class="h-20 w-20 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50 mb-2">No Products Found</h3>
            <p class="text-sm text-gray-600 dark:text-slate-400 mb-6">Get started by adding your first product to the inventory.</p>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Your First Product
            </a>
        </div>
    </div>
    @endif

    @if($products->hasPages())
    <div class="flex justify-center">
        <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg p-4">
            {{ $products->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    /* Custom pagination styling to match your design */
    .pagination {
        @apply flex items-center gap-2;
    }

    .pagination a,
    .pagination span {
        @apply px-3 py-1.5 text-sm rounded-lg transition-colors;
    }

    .pagination a {
        @apply text-gray-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:text-emerald-600 dark:hover:text-emerald-400;
    }

    .pagination .active span {
        @apply bg-emerald-500 text-white font-semibold;
    }

    .pagination .disabled span {
        @apply text-gray-400 dark:text-slate-600 cursor-not-allowed;
    }
</style>
@endsection