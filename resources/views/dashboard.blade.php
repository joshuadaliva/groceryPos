@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Sales Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Sales (This Month)</p>
                <p class="text-3xl font-bold text-green-600">₱{{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="text-4xl">💰</div>
        </div>
    </div>

    <!-- Transactions Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Transactions</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalTransactions }}</p>
            </div>
            <div class="text-4xl">📊</div>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Products</p>
                <p class="text-3xl font-bold text-purple-600">{{ $totalProducts }}</p>
            </div>
            <div class="text-4xl">📦</div>
        </div>
    </div>

    <!-- Low Stock Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Low Stock Items</p>
                <p class="text-3xl font-bold text-red-600">{{ $lowStockProducts }}</p>
            </div>
            <div class="text-4xl">⚠️</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Sales Trend -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
    <h3 class="text-xl font-bold mb-4">Sales Trend (Last 7 Days)</h3>
    <div class="space-y-2">
        @php
            // Calculate the divisor: Average daily sales this month
            $averageDailySales = $totalSales / 7;
        @endphp

        @foreach($salesTrend as $trend)
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">{{ $trend['date'] }}</span>
            <div class="w-40 bg-gray-200 rounded-full h-2">
                @php
                    $percentage = 0;
                    if ($averageDailySales > 0) {
                        $percentage = min(100, ($trend['amount'] / $averageDailySales) * 100);
                    }
                @endphp
                
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
            <span class="text-sm font-semibold">₱{{ number_format($trend['amount'], 2) }}</span>
        </div>
        @endforeach
    </div>
</div>

    <!-- Top Selling Products -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <h3 class="text-xl font-bold mb-4">Top Selling Products</h3>
        <div class="space-y-3">
            @forelse($topProducts as $product)
            <div class="flex items-center justify-between border-b pb-2">
                <div>
                    <p class="font-semibold">{{ $product->product_name }}</p>
                    <p class="text-sm text-gray-500">{{ $product->product_category }}</p>
                </div>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                    {{ $product->total_sold }} sold
                </span>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">No sales data available</p>
            @endforelse
        </div>
    </div>


    <!-- chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors">
        <h3 class="text-xl font-bold mb-4">Sales Chart</h3>
        <canvas id="salesChart"></canvas>
    </div>
</div>

<script>
const salesTrend = @json($salesTrend);
const dates = salesTrend.map(t => t.date);
const amounts = salesTrend.map(t => t.amount);

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
            borderWidth: 2,
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₱' + value.toFixed(0);
                    }
                }
            }
        }
    }
});
</script>
@endsection
