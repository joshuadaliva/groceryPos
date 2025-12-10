@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Page Header -->
    <div>
        <a href="{{ route('products.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Add New Product</h1>
        <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Fill in the details below to add a new product to your inventory</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 sm:p-8 transition-colors">
        <form method="POST" action="{{ route('products.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Product Image Upload with Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Product Image</label>
                <div id="image-preview" 
                     class="relative group max-w-sm mx-auto p-8 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-xl bg-gray-50 dark:bg-slate-800/50 hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors cursor-pointer">
                    <input id="product_image" 
                           type="file" 
                           name="product_image" 
                           accept="image/*" 
                           class="hidden">
                    <label for="product_image" class="cursor-pointer">
                        <div id="preview-content" class="text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h5 class="mb-2 text-base font-semibold text-gray-700 dark:text-slate-300">Upload Product Image</h5>
                            <p class="text-xs text-gray-500 dark:text-slate-400">Click to browse or drag and drop</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-2">Maximum size: <span class="font-medium">2MB</span></p>
                            <p class="text-xs text-gray-400 dark:text-slate-500">Formats: JPG, PNG, GIF</p>
                        </div>
                    </label>
                </div>
                @error('product_image')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Code & Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Product Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="product_code" 
                           value="{{ old('product_code') }}" 
                           placeholder="e.g., PROD-001"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors font-mono text-sm" 
                           required>
                    @error('product_code')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="product_category" 
                           value="{{ old('product_category') }}" 
                           placeholder="e.g., Beverages"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors" 
                           required>
                    @error('product_category')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Name (Full Width) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="product_name" 
                       value="{{ old('product_name') }}" 
                       placeholder="e.g., Coca-Cola 1.5L"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors" 
                       required>
                @error('product_name')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Stock Quantity -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Price (₱) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-slate-400 font-semibold">₱</span>
                        <input type="number" 
                               name="price" 
                               value="{{ old('price') }}" 
                               step="0.01" 
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors" 
                               required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock_quantity" 
                           value="{{ old('stock_quantity') }}" 
                           placeholder="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors" 
                           required>
                    @error('stock_quantity')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Description</label>
                <textarea name="description" 
                          rows="4" 
                          placeholder="Add product description, features, or notes..."
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('description') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-slate-800">
                <button type="submit" 
                        class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Product
                </button>
                <a href="{{ route('products.index') }}" 
                   class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-900 dark:text-slate-100 border border-gray-300 dark:border-slate-700/80 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadInput = document.getElementById('product_image');
    const imagePreview = document.getElementById('image-preview');
    const previewContent = document.getElementById('preview-content');

    uploadInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                uploadInput.value = '';
                return;
            }

            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid image file (JPG, PNG, or GIF)');
                uploadInput.value = '';
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewContent.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" 
                             class="max-h-64 rounded-lg mx-auto shadow-lg" 
                             alt="Product preview">
                        <div class="absolute top-2 right-2 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                            ✓ Uploaded
                        </div>
                        <p class="mt-3 text-sm text-gray-600 dark:text-slate-400 font-medium">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-500 mt-1">Click to change image</p>
                    </div>
                `;
                imagePreview.classList.remove('border-dashed');
                imagePreview.classList.add('border-solid', 'border-emerald-400', 'dark:border-emerald-500');
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Reset preview when clicking on it
    imagePreview.addEventListener('click', function() {
        if (uploadInput.files.length > 0) {
            // Optional: Could add a confirmation here
        }
    });
});
</script>
@endsection
