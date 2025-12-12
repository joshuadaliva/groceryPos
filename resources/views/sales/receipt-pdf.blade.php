@extends('layouts.app')

@section('title', 'Receipt')

@section('content')

<style>
    /* Custom CSS for thermal receipt look */
    .receipt-container {
        /* Max width for standard thermal printer paper (approx 320px) */
        max-width: 320px; 
        /* Ensure content doesn't break outside the width */
        word-wrap: break-word; 
    }
    .dashed-divider {
        border-top: 1px dashed #777;
    }
    /* Hide buttons/actions when printing */
    @media print {
        .no-print {
            display: none;
        }
        /* Ensure the receipt itself is the only thing visible and takes full width */
        .receipt-container {
            max-width: none !important;
            width: 100%;
            margin: 0;
            box-shadow: none;
            padding: 0;
        }
    }
</style>

<div class="receipt-container mx-auto bg-white shadow-xl p-4 font-mono text-sm">

    <div class="text-center mb-4 border-b pb-3">
        <h1 class="text-xl font-extrabold tracking-widest text-gray-800">FASTPOS STORE</h1>
        <p class="text-xs text-gray-500 mt-1">123 Main St, Central City, 54321</p>
        <p class="text-xs text-gray-500">Phone: (123) 456-7890</p>
    </div>

    <div class="space-y-1 mb-4">
        <div class="flex justify-between">
            <span class="text-gray-700">Invoice:</span>
            <span class="font-semibold">{{ $sale->invoice_number }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-700">Date:</span>
            <span class="font-semibold">{{ $sale->sale_date->format('M d, Y') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-700">Time:</span>
            <span class="font-semibold">{{ $sale->sale_date->format('H:i:s A') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-700">Cashier:</span>
            <span class="font-semibold">{{ $sale->user->name }}</span>
        </div>
    </div>

    <div class="dashed-divider pt-2 mb-2">
        <table class="w-full text-xs">
            <thead>
                <tr class="border-b-0">
                    <th class="text-left py-1 w-2/5">ITEM</th>
                    <th class="text-right py-1 w-1/5">QTY</th>
                    <th class="text-right py-1 w-1/5">@ PRICE</th>
                    <th class="text-right py-1 w-1/5">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                {{-- Products are displayed here by looping through saleDetails --}}
                
                @foreach ($sale->saleDetails as $detail)
                <tr>
                    {{-- ADDED CLASSES for alignment and vertical padding --}}
                    <td class="text-left py-1">{{ $detail->product->name }}</td>
                    <td class="text-right py-1">{{ $detail->quantity }}</td>
                    <td class="text-right py-1">₱{{ number_format($detail->price, 2) }}</td>
                    <td class="text-right py-1">₱{{ number_format($detail->quantity * $detail->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="space-y-1 mt-4">
        <div class="dashed-divider pt-2 flex justify-between">
            <span class="font-normal">Subtotal:</span>
            <span class="font-semibold">₱{{ number_format($sale->total_amount, 2) }}</span>
        </div>
        
        <div class="flex justify-between">
            <span class="font-normal">Tax (0%):</span>
            <span class="font-semibold">₱{{ number_format(0, 2) }}</span>
        </div>
        
        <div class="dashed-divider pt-2 flex justify-between text-base font-extrabold text-gray-800">
            <span>GRAND TOTAL:</span>
            <span>₱{{ number_format($sale->total_amount, 2) }}</span>
        </div>
    </div>
    
    <div class="space-y-1 mt-4 border-t-2 border-dashed pt-4">
        <div class="flex justify-between">
            <span class="font-normal">Tendered (CASH):</span>
            <span class="font-semibold">₱{{ number_format($sale->amount_paid, 2) }}</span>
        </div>
        <div class="flex justify-between text-green-700 font-bold">
            <span class="text-lg">CHANGE:</span>
            <span class="text-lg">₱{{ number_format($sale->change_amount, 2) }}</span>
        </div>
    </div>

    <div class="text-center pt-6 text-gray-700">
        <p class="text-xs font-semibold">--- THANK YOU FOR SHOPPING ---</p>
        <p class="text-xs mt-1">Visit us again soon!</p>
    </div>

    <div class="flex gap-4 mt-8 no-print">
        <button onclick="window.print()" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
            🖨️ Print Receipt
        </button>
        <a href="{{ route('pos.index') }}" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 text-center transition">
            🛒 New Sale
        </a>
    </div>
</div>
@endsection