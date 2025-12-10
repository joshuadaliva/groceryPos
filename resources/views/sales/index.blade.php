@extends('layouts.app')

@section('title', 'Sales History')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Sales History</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="POST" action="{{ route('sales.filter') }}" class="flex gap-4">
        @csrf
        <input type="date" name="start_date" class="px-4 py-2 border rounded-lg">
        <input type="date" name="end_date" class="px-4 py-2 border rounded-lg">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Filter</button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Invoice #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Date & Time</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Cashier</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Total Amount</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3 text-sm font-mono">{{ $sale->invoice_number }}</td>
                <td class="px-6 py-3 text-sm">{{ $sale->sale_date->format('M d, Y H:i') }}</td>
                <td class="px-6 py-3 text-sm">{{ $sale->user->name }}</td>
                <td class="px-6 py-3 text-sm font-semibold">₱{{ number_format($sale->total_amount, 2) }}</td>
                <td class="px-6 py-3 text-sm">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">✓ {{ ucfirst($sale->payment_status) }}</span>
                </td>
                <td class="px-6 py-3 text-center text-sm">
                    <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-800">👁️ View</a>
                    <a href="{{ route('sales.receipt', $sale) }}" class="text-green-600 hover:text-green-800 ml-3">📄 Receipt</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No sales found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($sales->hasPages())
<div class="mt-6 flex justify-center">
    {{ $sales->links() }}
</div>
@endif
@endsection
