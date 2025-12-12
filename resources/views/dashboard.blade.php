@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Dashboard</h1>
            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Welcome back! Here's your store overview.</p>
        </div>
        <div class="hidden sm:block">
            <span class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full border border-emerald-400/40 bg-emerald-500/10 text-emerald-600 dark:text-emerald-300">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Live Data
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Sales Card -->
        <div class="group rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 transition-all duration-200 hover:shadow-xl hover:shadow-emerald-500/20 dark:hover:shadow-emerald-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/15 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    💰
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                    This Month
                </span>
            </div>
            <p class="text-sm text-gray-600 dark:text-slate-400 mb-1">Total Sales</p>
            <p class="text-2xl sm:text-3xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($totalSales, 2) }}</p>
        </div>

        <!-- Transactions Card -->
        <div class="group rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-blue-500/5 p-6 transition-all duration-200 hover:shadow-xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-blue-500/10 dark:bg-blue-500/15 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    📊
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-slate-400 mb-1">Transactions</p>
            <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalTransactions }}</p>
            <p class="text-xs text-gray-500 dark:text-slate-500 mt-2">Total completed</p>
        </div>

        <!-- Total Products Card -->
        <div class="group rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-purple-500/5 p-6 transition-all duration-200 hover:shadow-xl hover:shadow-purple-500/20 dark:hover:shadow-purple-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-purple-500/10 dark:bg-purple-500/15 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    📦
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-slate-400 mb-1">Total Products</p>
            <p class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalProducts }}</p>
            <p class="text-xs text-gray-500 dark:text-slate-500 mt-2">In inventory</p>
        </div>

        <!-- Low Stock Card -->
        <div class="group rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-red-500/5 p-6 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/20 dark:hover:shadow-red-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-red-500/10 dark:bg-red-500/15 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    ⚠️
                </div>
                @if($lowStockProducts > 0)
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-500/15 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-500/30 animate-pulse">
                    Alert
                </span>
                @endif
            </div>
            <p class="text-sm text-gray-600 dark:text-slate-400 mb-1">Low Stock Items</p>
            <p class="text-2xl sm:text-3xl font-bold text-red-600 dark:text-red-400">{{ $lowStockProducts }}</p>
            <p class="text-xs text-gray-500 dark:text-slate-500 mt-2">Needs restocking</p>
        </div>
    </div>

    <!-- Charts and Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Sales Trend -->
        <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 transition-colors">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50">Sales Trend</h3>
                <span class="text-xs text-gray-500 dark:text-slate-400">Last 7 Days</span>
            </div>

            <div class="space-y-4">
                @php
                $maxAmount = collect($salesTrend)->max('amount');
                $maxAmount = $maxAmount > 0 ? $maxAmount : 1;
                @endphp

                @foreach($salesTrend as $trend)
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-slate-400 font-medium">{{ $trend['date'] }}</span>
                        <span class="text-gray-900 dark:text-slate-100 font-semibold">₱{{ number_format($trend['amount'], 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                        @php
                        $percentage = ($trend['amount'] / $maxAmount) * 100;
                        @endphp
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 transition-colors">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50">Top Selling Products</h3>
                <span class="text-xs text-gray-500 dark:text-slate-400">This Month</span>
            </div>

            <div class="space-y-3">
                @forelse($topProducts as $index => $product)
                <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/60 hover:bg-gray-100 dark:hover:bg-slate-900 transition-colors">
                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/15 flex items-center justify-center">
                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">#{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-slate-100 truncate">{{ $product->product_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $product->product_category }}</p>
                    </div>
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                        </svg>
                        {{ $product->total_sold }}
                    </span>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-3 opacity-50">📊</div>
                    <p class="text-gray-500 dark:text-slate-400">No sales data available</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-lg shadow-gray-200/50 dark:shadow-emerald-500/5 p-6 transition-colors">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-50">Sales Chart</h3>
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-slate-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Daily Sales (Last 7 Days)
                </div>
            </div>
            <div class="relative h-64 sm:h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const salesTrend = @json($salesTrend);
        const dates = salesTrend.map(t => t.date);
        const amounts = salesTrend.map(t => t.amount);

        // Check if dark mode is enabled
        const isDarkMode = document.documentElement.classList.contains('dark');

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Daily Sales',
                    data: amounts,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: 'rgb(34, 197, 94)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                        titleColor: isDarkMode ? '#f1f5f9' : '#0f172a',
                        bodyColor: isDarkMode ? '#cbd5e1' : '#475569',
                        borderColor: isDarkMode ? 'rgba(34, 197, 94, 0.3)' : 'rgba(34, 197, 94, 0.2)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        border: {
                            display: false
                        },
                        grid: {
                            color: isDarkMode ? 'rgba(148, 163, 184, 0.1)' : 'rgba(148, 163, 184, 0.2)',
                            drawTicks: false
                        },
                        ticks: {
                            padding: 10,
                            color: isDarkMode ? '#94a3b8' : '#64748b',
                            callback: function(value) {
                                return '₱' + value.toFixed(0);
                            }
                        }
                    },
                    x: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10,
                            color: isDarkMode ? '#94a3b8' : '#64748b'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endsection