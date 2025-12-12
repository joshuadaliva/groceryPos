@extends('layouts.app')

@section('title', 'Sale Details: ' . $sale->invoice_number)

@section('content')
<div class="space-y-6">
    <div>
        {{-- Consistent back link design with icon and hover effect --}}
        <a href="{{ route('sales.index') }}" 
           class="text-sm text-gray-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors inline-flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Sales History
        </a>
        {{-- Consistent title style --}}
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">
            Sale Details: <span class="font-mono">{{ $sale->invoice_number }}</span>
        </h1>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 sm:p-8 transition-colors">
        
        <h2 class="text-xl font-semibold text-gray-900 dark:text-slate-50 mb-6 border-b border-gray-200 dark:border-slate-800 pb-3">Transaction Info</h2>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-y-6 gap-x-8 mb-8">
            
            {{-- Invoice Number --}}
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Invoice Number</p>
                <p class="text-xl font-mono font-bold text-gray-900 dark:text-slate-50">{{ $sale->invoice_number }}</p>
            </div>
            
            {{-- Sale Date --}}
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Sale Date</p>
                <p class="text-xl font-semibold text-gray-900 dark:text-slate-50">{{ $sale->sale_date->format('M d, Y H:i A') }}</p>
            </div>
            
            {{-- Cashier --}}
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Cashier</p>
                <p class="text-xl font-semibold text-gray-900 dark:text-slate-50">{{ $sale->user->name }}</p>
            </div>
            
            {{-- Payment Status (Styled like index page) --}}
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-1">Payment Status</p>
                <p class="text-xl font-semibold">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Totals Summary --}}
        <div class="max-w-sm ml-auto space-y-3 border-t border-gray-200 dark:border-slate-800 pt-6">
            {{-- Total Amount --}}
            <div class="flex justify-between text-lg text-gray-700 dark:text-slate-300">
                <span class="font-medium">Total Amount:</span>
                <span class="font-semibold text-gray-900 dark:text-slate-50">₱{{ number_format($sale->total_amount, 2) }}</span>
            </div>
            
            {{-- Amount Paid --}}
            <div class="flex justify-between text-lg text-gray-700 dark:text-slate-300">
                <span class="font-medium">Amount Paid:</span>
                <span class="font-semibold text-gray-900 dark:text-slate-50">₱{{ number_format($sale->amount_paid, 2) }}</span>
            </div>
            
            {{-- Change (Accent color for final value) --}}
            <div class="flex justify-between text-2xl border-t border-gray-200 dark:border-slate-800 pt-3 mt-3 text-emerald-600 dark:text-emerald-400">
                <span class="font-bold">Change:</span>
                <span class="font-extrabold">₱{{ number_format($sale->change_amount, 2) }}</span>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('sales.receipt', $sale) }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download Receipt
        </a>
    </div>
</div>
@endsection