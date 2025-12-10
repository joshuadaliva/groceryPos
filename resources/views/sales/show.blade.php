@extends('layouts.app')

@section('title', 'Sale Details: ' . $sale->invoice_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-800">← Back to Sales History</a>
    <h1 class="text-3xl font-bold mt-2">Sale Details: {{ $sale->invoice_number }}</h1>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <div class="grid grid-cols-2 gap-y-4 gap-x-8 mb-8 border-b pb-6">
        <div>
            <p class="text-sm font-medium text-gray-500">Invoice Number</p>
            <p class="text-xl font-semibold">{{ $sale->invoice_number }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Sale Date</p>
            <p class="text-xl font-semibold">{{ $sale->sale_date->format('M d, Y H:i A') }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Cashier</p>
            <p class="text-xl font-semibold">{{ $sale->user->name }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Payment Status</p>
            <p class="text-xl font-semibold">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">✓ {{ ucfirst($sale->payment_status) }}</span>
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Purchased Items</h2>

    <table class="w-full mb-8">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold">Product Code</th>
                <th class="px-4 py-2 text-left text-sm font-semibold">Product Name</th>
                <th class="px-4 py-2 text-right text-sm font-semibold">Quantity</th>
                <th class="px-4 py-2 text-right text-sm font-semibold">Price</th>
                <th class="px-4 py-2 text-right text-sm font-semibold">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleDetails as $detail)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 text-sm font-mono">{{ $detail->product->product_code }}</td>
                <td class="px-4 py-2 text-sm">{{ $detail->product->product_name }}</td>
                <td class="px-4 py-2 text-right text-sm">{{ $detail->quantity }}</td>
                <td class="px-4 py-2 text-right text-sm">₱{{ number_format($detail->price, 2) }}</td>
                <td class="px-4 py-2 text-right text-sm font-semibold">₱{{ number_format($detail->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="max-w-xs ml-auto space-y-2 border-t pt-4">
        <div class="flex justify-between text-lg">
            <span class="font-normal">Total Amount:</span>
            <span class="font-bold">₱{{ number_format($sale->total_amount, 2) }}</span>
        </div>
        <div class="flex justify-between text-lg">
            <span class="font-normal">Amount Paid:</span>
            <span class="font-bold">₱{{ number_format($sale->amount_paid, 2) }}</span>
        </div>
        <div class="flex justify-between text-2xl text-green-700">
            <span class="font-bold">Change:</span>
            <span class="font-extrabold">₱{{ number_format($sale->change_amount, 2) }}</span>
        </div>
    </div>
</div>
@endsection