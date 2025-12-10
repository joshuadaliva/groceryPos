<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Grocery POS') }} - @yield('title')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
        
        <!-- Dark mode script (runs before page loads to avoid flash) -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            @auth
            <nav class="w-64 bg-white dark:bg-gray-800 shadow-lg transition-colors duration-200">
                <div class="p-6 border-b dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-green-600 dark:text-green-400">Grocery POS</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->name }}</p>
                </div>

                <ul class="py-4">
                    <li>
                        <a href="{{ route('dashboard') }}" class="block px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-gray-700 @if(Route::is('dashboard')) bg-green-100 dark:bg-gray-700 font-bold @endif transition-colors">
                            <span class="inline-block mr-2">📊</span> Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->isAdmin())
                    <li>
                        <a href="{{ route('products.index') }}" class="block px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-gray-700 @if(Route::is('products.*')) bg-green-100 dark:bg-gray-700 font-bold @endif transition-colors">
                            <span class="inline-block mr-2">📦</span> Products
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('sales.index') }}" class="block px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-gray-700 @if(Route::is('sales.*')) bg-green-100 dark:bg-gray-700 font-bold @endif transition-colors">
                            <span class="inline-block mr-2">📋</span> Sales History
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('pos.index') }}" class="block px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-gray-700 @if(Route::is('pos.*')) bg-green-100 dark:bg-gray-700 font-bold @endif transition-colors">
                            <span class="inline-block mr-2">🛒</span> POS
                        </a>
                    </li>

                    <!-- Theme Toggle -->
                    <li class="border-t dark:border-gray-700 mt-4 pt-4">
                        <button onclick="toggleTheme()" class="w-full text-left px-6 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="inline-block mr-2">🌓</span> 
                            <span id="theme-toggle-text">Light Mode</span>
                        </button>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="px-6">
                            @csrf
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 w-full text-left transition-colors">
                                <span class="inline-block mr-2">🚪</span> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            @endauth

            <!-- Main Content -->
            <main class="flex-1">
                @auth
                <div class="p-8">
                    @if($errors->any())
                    <div class="mb-4 bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-200 px-4 py-3 rounded transition-colors">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="mb-4 bg-green-100 dark:bg-green-900/50 border border-green-400 dark:border-green-500 text-green-700 dark:text-green-200 px-4 py-3 rounded transition-colors">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-500 text-red-700 dark:text-red-200 px-4 py-3 rounded transition-colors">
                        {{ session('error') }}
                    </div>
                    @endif

                    @yield('content')
                </div>
                @else
                <div class="h-screen flex items-center justify-center">
                    @yield('content')
                </div>
                @endauth
            </main>
        </div>

        <!-- Theme Toggle Script -->
        <script>
            function toggleTheme() {
                const html = document.documentElement;
                const currentTheme = localStorage.getItem('theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                localStorage.setItem('theme', newTheme);
                
                if (newTheme === 'dark') {
                    html.classList.add('dark');
                    document.getElementById('theme-toggle-text').textContent = 'Light Mode';
                } else {
                    html.classList.remove('dark');
                    document.getElementById('theme-toggle-text').textContent = 'Dark Mode';
                }
            }

            // Set initial text on page load
            document.addEventListener('DOMContentLoaded', function() {
                const currentTheme = localStorage.getItem('theme') || 'light';
                const toggleText = document.getElementById('theme-toggle-text');
                if (toggleText) {
                    toggleText.textContent = currentTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
                }
            });
        </script>
    </body>
</html>
