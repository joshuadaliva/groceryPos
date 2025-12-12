@extends('layouts.app')

@section('title', 'Point of Sale')

@section('content')
{{-- Added 'lg:' prefixes for grid to ensure responsiveness on small screens --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
    <div class="lg:col-span-2">
        {{-- Updated card styling for consistency and dark mode --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-slate-50">POS System</h2>

            <div class="mb-6">
                {{-- Added dark mode text color to label --}}
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Scan Barcode or Enter Product Code</label>
                {{-- Added dark mode styling to input --}}
                <input
                    type="text"
                    id="barcodeInput"
                    class="w-full px-4 py-2 border-2 border-green-600 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent dark:bg-slate-700 dark:text-slate-100 dark:border-green-500"
                    placeholder="Press Enter to add product"
                    autofocus>
            </div>
            {{-- Updated container styling for dark mode and visual consistency --}}
            <div id="inlineScannerArea" class="mb-6 border border-gray-200 dark:border-slate-700 p-4 rounded-xl bg-gray-50 dark:bg-slate-900">
                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-slate-200">Live Barcode Scan</h3>

                <div class="max-h-32 overflow-y-scroll">
                    <div id="reader" style="width: 100%;"></div>
                </div>

                <button type="button" onclick="stopScanner()" class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors">
                    ❌ Stop Scanner
                </button>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-slate-200">Available Products</h3>
                <div class="grid grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                    @foreach($products as $product)
                    {{-- Updated product card styling for dark mode, hover state, and consistency --}}
                    <div class="border border-gray-200 dark:border-slate-700 rounded-xl p-4 cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20" onclick="addProduct({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }}, {{ $product->stock_quantity }})">
                        <p class="font-semibold text-gray-900 dark:text-slate-50">{{ $product->product_name }}</p>
                        <p class="text-sm text-gray-600 dark:text-slate-400">₱{{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-500 dark:text-slate-500">Stock: {{ $product->stock_quantity }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 h-full flex flex-col ">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-slate-50">Shopping Cart</h2>

        <div id="cartItems" class="flex-1 max-h-96 overflow-y-scroll ">
            <p class="text-gray-500 dark:text-slate-500 text-center py-8">Cart is empty</p>
        </div>
        <div class="border-t border-gray-200 dark:border-slate-700 pt-4 space-y-2 mb-6 text-gray-700 dark:text-slate-300">
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span id="subtotal">₱0.00</span>
            </div>
            <div class="flex justify-between">
                <span>Tax (0%):</span>
                <span id="tax">₱0.00</span>
            </div>
            <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-slate-700 pt-2 text-gray-900 dark:text-slate-50">
                <span>Total:</span>
                <span id="total">₱0.00</span>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                {{-- Added dark mode text color to label --}}
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Amount Paid (₱)</label>
                {{-- Added dark mode styling to input --}}
                <input type="number" id="amountPaid" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100" placeholder="0.00" step="0.01">
            </div>

            {{-- Updated Change display styling for dark mode and consistency --}}
            <div class="bg-gray-100 dark:bg-slate-700 p-3 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-slate-400">Change:</p>
                <p class="text-2xl font-bold text-green-600" id="change">₱0.00</p>
            </div>

            <button onclick="checkout()" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition-colors">
                💳 Complete Sale
            </button>

            <button onclick="clearCart()" class="w-full bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700 transition-colors">
                🗑️ Clear Cart
            </button>
        </div>
    </div>
</div>

<script>
    let cart = [];

    // Add product to cart
    function addProduct(id, name, price, stock) {
        const numericPrice = parseFloat(price);
        const numericStock = parseInt(stock);
        if (stock <= 0) {
            alert('Product out of stock!');
            return;
        }

        const existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            if (existingItem.quantity < stock) {
                existingItem.quantity++;
            } else {
                alert('Cannot add more than available stock!');
                return;
            }
        } else {
            cart.push({
                id,
                name,
                price: numericPrice,
                quantity: 1,
                stock: numericStock
            });
        }

        updateCart();
        document.getElementById('barcodeInput').value = '';
        document.getElementById('barcodeInput').focus();
    }

    // Remove product from cart
    function removeProduct(id) {
        cart = cart.filter(item => item.id !== id);
        updateCart();
    }

    // Update quantity
    function updateQuantity(id, quantity) {
        const item = cart.find(item => item.id === id);
        if (item) {
            const q = parseInt(quantity);
            if (q > 0 && q <= item.stock) {
                item.quantity = q;
                updateCart();
            }
        }
    }

    // Update cart display
    function updateCart() {
        const cartItemsDiv = document.getElementById('cartItems');

        if (cart.length === 0) {
            // Added dark mode text color for empty cart message
            cartItemsDiv.innerHTML = '<p class="text-gray-500 dark:text-slate-500 text-center py-8">Cart is empty</p>';
            updateTotals();
            return;
        }

        cartItemsDiv.innerHTML = cart.map(item => `
        {{-- Added dark mode border and text colors to dynamically created cart items --}}
        <div class="border-b border-gray-200 dark:border-slate-700 pb-3 mb-3 text-gray-900 dark:text-slate-50">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">${item.name}</span>
                <button onclick="removeProduct(${item.id})" class="text-red-600 text-sm">Remove</button>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-600 dark:text-slate-400">₱${item.price.toFixed(2)}</span>
                <span>₱${(item.price * item.quantity).toFixed(2)}</span>
            </div>
            <div class="flex items-center gap-2 text-gray-700 dark:text-slate-300">
                <label class="text-sm">Qty:</label>
                {{-- Added dark mode styling to quantity input --}}
                <input type="number" value="${item.quantity}" min="1" max="${item.stock}" 
                       onchange="updateQuantity(${item.id}, this.value)" class="w-16 px-2 py-1 border rounded dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100">
            </div>
        </div>
    `).join('');

        updateTotals();
    }

    // Update totals
    function updateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = 0;
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = '₱' + subtotal.toFixed(2);
        document.getElementById('tax').textContent = '₱' + tax.toFixed(2);
        document.getElementById('total').textContent = '₱' + total.toFixed(2);

        // Calculate change
        const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
        const change = amountPaid - total;
        document.getElementById('change').textContent = '₱' + (change >= 0 ? change.toFixed(2) : '0.00');
    }

    // Barcode input handler
    document.getElementById('barcodeInput').addEventListener('keypress', async function(e) {
        if (e.key === 'Enter') {
            const code = this.value.trim();
            if (code) {
                try {
                    const response = await fetch(`/product/code/${code}`);
                    if (response.ok) {
                        const product = await response.json();
                        addProduct(product.id, product.product_name, product.price, product.stock_quantity);
                    } else {
                        alert('Product not found!');
                    }
                } catch (error) {
                    alert('Error scanning product!');
                }
                this.value = '';
            }
        }
    });

    // Amount paid change handler
    document.getElementById('amountPaid').addEventListener('input', updateTotals);

    // Clear cart
    function clearCart() {
        if (confirm('Clear all items from cart?')) {
            cart = [];
            updateCart();
            document.getElementById('amountPaid').value = '';
        }
    }

    // Checkout
    async function checkout() {
        if (cart.length === 0) {
            alert('Cart is empty!');
            return;
        }

        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;

        if (amountPaid < subtotal) {
            alert('Insufficient payment!');
            return;
        }

        try {
            const response = await fetch('{{ route("pos.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity
                    })),
                    total_amount: subtotal,
                    amount_paid: amountPaid
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Sale completed successfully!');
                window.location.href = `/pos/receipt/${data.sale.id}`;
            } else {
                alert('Error: ' + data.error);
            }
        } catch (error) {
            alert('Error completing sale!');
            console.error(error);
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
<script>
    let html5QrcodeScanner;
    let isScanningPaused = false;

    // Initialize the scanner immediately when the page loads
    document.addEventListener('DOMContentLoaded', initializeScanner);

    function initializeScanner() {
        const config = {
            fps: 10,
            qrbox: {
                width: 250,
                height: 100
            },
            formatsToSupport: [
                Html5QrcodeSupportedFormats.UPC_A,
                Html5QrcodeSupportedFormats.EAN_13,
                Html5QrcodeSupportedFormats.CODE_128,
                Html5QrcodeSupportedFormats.CODE_39,
            ],
            rememberLastUsedCamera: true
        };

        // Check for Html5QrcodeSupportedFormats availability
        if (typeof Html5QrcodeSupportedFormats === 'undefined') {
            console.warn("Html5QrcodeSupportedFormats not defined. Using default scanner settings.");
            html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 100
                }
            }, false);
        } else {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                config,
                false
            );
        }

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (isScanningPaused) {
            return; // Ignore scan if currently paused (throttle)
        }

        // Throttle: Pause for 1 second to prevent multiple reads of the same barcode
        isScanningPaused = true;
        setTimeout(() => {
            isScanningPaused = false;
        }, 1000); // 1000ms delay

        // FIX: Trim the scanned code for accurate lookup
        const code = String(decodedText).trim();

        // Search for product with scanned code
        fetch(`/product/code/${code}`)
            .then(response => {
                if (response.status === 404) {
                    alert(`Product not found with code: ${code}`);
                    throw new Error('Product not found.');
                }
                if (!response.ok) {
                    throw new Error(`Server error: ${response.status}`);
                }
                return response.json();
            })
            .then(product => {
                // FIX: Convert price and stock from API strings to numbers before calling addProduct
                addProduct(
                    product.id,
                    product.product_name,
                    parseFloat(product.price),
                    parseInt(product.stock_quantity)
                );
            })
            .catch(error => {
                if (!error.message.includes('Product not found')) {
                    console.error('Camera Scan Error:', error);
                    alert('Error processing scan. Check console.');
                }
            });
    }

    function onScanFailure(error) {
        // Kept empty to prevent continuous alerts during live scanning
    }

    // Renamed stopCamera to stopScanner
    function stopScanner() {
        if (html5QrcodeScanner) {
            try {
                html5QrcodeScanner.clear();
            } catch (e) {
                console.error("Error clearing scanner:", e);
            }
        }
    }
</script>


@endsection