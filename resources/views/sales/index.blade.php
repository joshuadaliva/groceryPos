@extends('layouts.app')

@section('title', 'Sales History')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Sales History</h1>
        <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">View and manage all sales transactions</p>
    </div>



    <!-- Filters Card -->
    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-3 transition-colors">
        <form method="POST" action="{{ route('sales.filter') }}" class="space-y-4">
            @csrf
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-slate-50">Filter Sales</h3>
                @if(request()->has('start_date') || request()->has('end_date'))
                    <a href="{{ route('sales.index') }}" 
                       class="text-xs text-gray-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        Clear filters
                    </a>
                @endif
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Start Date</label>
                    <input type="date" 
                           name="start_date" 
                           value="{{ request('start_date') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">End Date</label>
                    <input type="date" 
                           name="end_date" 
                           value="{{ request('end_date') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sales Table -->
    <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 overflow-hidden transition-colors">
        <!-- Mobile View (Cards) -->
        <div class="lg:hidden divide-y divide-gray-200 dark:divide-slate-800">
            @forelse($sales as $sale)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Invoice #</p>
                        <p class="text-sm font-mono font-semibold text-gray-900 dark:text-slate-100">{{ $sale->invoice_number }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                </div>
                
                <div class="space-y-2 mb-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-slate-400">Date & Time</span>
                        <span class="text-gray-900 dark:text-slate-100">{{ $sale->sale_date->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-slate-400">Cashier</span>
                        <span class="text-gray-900 dark:text-slate-100">{{ $sale->user->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-slate-400">Total Amount</span>
                        <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('sales.show', $sale) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('sales.receipt', $sale) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Receipt
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="text-5xl mb-3 opacity-50">📋</div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50 mb-2">No Sales Found</h3>
                <p class="text-sm text-gray-600 dark:text-slate-400">There are no sales transactions to display.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-slate-800/50 border-b border-gray-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Cashier</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-mono font-semibold text-gray-900 dark:text-slate-100">{{ $sale->invoice_number }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                            {{ $sale->sale_date->format('M d, Y') }}<br>
                            <span class="text-xs">{{ $sale->sale_date->format('h:i A') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-slate-100">{{ $sale->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="text-base font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($sale->total_amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                {{ ucfirst($sale->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('sales.show', $sale) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('sales.receipt', $sale) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Receipt
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-5xl mb-3 opacity-50">📋</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50 mb-2">No Sales Found</h3>
                            <p class="text-sm text-gray-600 dark:text-slate-400">There are no sales transactions to display.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($sales->hasPages())
    <div class="flex justify-center">
        <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg p-4">
            {{ $sales->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    /* Custom pagination styling */
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
