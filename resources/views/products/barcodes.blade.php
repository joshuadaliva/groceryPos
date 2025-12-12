@extends('layouts.app')

@section('title', 'Product Barcodes for Printing')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Printable Barcodes</h1>
            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Generate labels for all your products. Use your browser's print function (Ctrl+P / Cmd+P) after loading this page.</p>
        </div>
        <button onclick="window.print()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-blue-500 hover:bg-blue-400 text-white shadow-lg shadow-blue-500/40 transition-all duration-200 hover:shadow-blue-500/50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2v5H3v-5h2M17 9v4.582m0 0l-2-2m2 2l2-2m-1-5H9v4.582"></path>
            </svg>
            Print Labels
        </button>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-3 gap-3 sm:gap-4 print:gap-1">
        @php
        // Instantiate the HTML generator once
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // Using a lower width factor (0.8) makes the bars narrower, preventing overflow.
        $widthFactor = 1;
        $height = 30; // height in pixels
        @endphp

        @foreach($products as $product)
        <div class="barcode-label p-2 border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm rounded-lg transition-all print:shadow-none print:border-dashed print:border-gray-400 print:rounded-none print:break-inside-avoid print:p-1.5">

            <p class="text-xs font-semibold text-gray-900 dark:text-slate-50 truncate mb-1" title="{{ $product->product_name }}">
                {{ $product->product_name }}
            </p>

            <div class="text-center py-1">
                {{-- Generate Barcode using CODE_128 with reduced width factor (0.8) --}}
                <div class="barcode-container" style="background-color:white; font-size: 10px; line-height: 1; overflow-x: auto; white-space: nowrap;">
                    {{-- Passing $widthFactor and $height directly --}}
                    {!! $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128, $widthFactor, $height) !!}
                </div>
            </div>

            <div class="flex items-center justify-between mt-1 pt-1 border-t border-gray-100 dark:border-slate-800 print:border-none">
                <span class="text-xs font-mono text-gray-700 dark:text-slate-300 print:text-black">
                    {{ $product->product_code }}
                </span>
                <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400 print:text-black">
                    ₱{{ number_format($product->price, 2) }}
                </span>
            </div>


        </div>
        @endforeach
    </div>
</div>

<style>
    @media print {
        body {
            margin: 0 !important;
            padding: 0 !important;
            min-width: 0 !important;
        }

        .print\:hidden,
        header,
        footer,
        .space-y-6>.flex:first-child {
            display: none !important;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr) !important;
        }

        .barcode-label {
            height: auto;
            page-break-inside: avoid;
        }

        .barcode-container {
            transform-origin: top left;
            width: 100%;
        }

        .barcode-container>div {
            max-width: 100%;
            overflow: hidden;
        }
    }
</style>
@endsection