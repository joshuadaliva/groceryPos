<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Grocery POS') }} - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Dark mode script (runs before page loads to avoid flash) -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-slate-950 transition-colors duration-200">
    <div class="min-h-screen">
        @auth
        <!-- Mobile Header -->
        <header class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-gray-200 dark:border-slate-800/80 transition-colors">
            <div class="flex items-center justify-between px-4 h-16">
                <div class="flex items-center gap-2">
                    <div class="h-9 px-2 rounded-xl bg-emerald-500/90 flex items-center justify-center shadow-lg shadow-emerald-500/40">
                        <span class="text-xl font-black tracking-tight text-white">Bentoda</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-tight text-gray-900 dark:text-slate-50">Mini Grocery</p>
                        <p class="text-[10px] text-gray-600 dark:text-slate-400">POS System</p>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    id="mobile-menu-button"
                    type="button"
                    class="p-2 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors"
                    aria-label="Toggle menu">
                    <svg class="w-6 h-6 text-gray-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div
            id="sidebar-overlay"
            class="fixed inset-0 bg-gray-900/50 dark:bg-slate-950/80 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity"
            onclick="toggleMobileSidebar()">
        </div>

        <!-- Sidebar -->
        <nav
            id="sidebar"
            class="fixed top-0 left-0 z-50 h-screen w-64 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-r border-gray-200 dark:border-slate-800/80 shadow-2xl transition-transform duration-300 -translate-x-full lg:translate-x-0">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <div class="h-10 px-2 rounded-xl bg-emerald-500/90 flex items-center justify-center shadow-lg shadow-emerald-500/40">
                        <span class="text-xl font-black tracking-tight text-white">Bentoda</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-tight text-gray-900 dark:text-slate-50">Mini Grocery</p>
                        <p class="text-[10px] text-gray-600 dark:text-slate-400">POS & Inventory</p>
                    </div>
                </div>

                <!-- Close Button (Mobile Only) -->
                <button
                    id="sidebar-close"
                    class="lg:hidden p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors"
                    onclick="toggleMobileSidebar()">
                    <svg class="w-5 h-5 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- User Info -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-emerald-500/10 dark:bg-emerald-500/15 flex items-center justify-center">
                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-slate-50 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">
                            @if(Auth::user()->isAdmin())
                            Administrator
                            @else
                            Cashier
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="py-4 px-3 space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all @if(Route::is('dashboard')) bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 @endif"
                        onclick="closeMobileSidebarOnNavigate()">
                        <span class="text-lg">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(Auth::user()->isAdmin())
                <li>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all @if(Route::is('products.*')) bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 @endif"
                        onclick="closeMobileSidebarOnNavigate()">
                        <span class="text-lg">📦</span>
                        <span>Products</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('sales.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all @if(Route::is('sales.*')) bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 @endif"
                        onclick="closeMobileSidebarOnNavigate()">
                        <span class="text-lg">📋</span>
                        <span>Sales History</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ route('pos.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all @if(Route::is('pos.*')) bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 shadow-sm @else text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 @endif"
                        onclick="closeMobileSidebarOnNavigate()">
                        <span class="text-lg">🛒</span>
                        <span>Point of Sale</span>
                    </a>
                </li>
            </ul>

            <!-- Bottom Actions -->
            <div class="absolute bottom-0 left-0 right-0 p-3 space-y-1 border-t border-gray-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80">
                <!-- Theme Toggle -->
                <button
                    onclick="toggleTheme()"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                    <span class="text-lg">🌓</span>
                    <span id="theme-toggle-text">Toggle Theme</span>
                </button>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors">
                        <span class="text-lg">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="lg:ml-64 min-h-screen pt-16 lg:pt-0">
            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Alerts -->
                @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-400 dark:border-red-500/30 bg-red-50 dark:bg-red-900/20 backdrop-blur-xl p-4 transition-colors">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">⚠️</span>
                        <ul class="flex-1 space-y-1 text-sm text-red-700 dark:text-red-200">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-400 dark:border-emerald-500/30 bg-emerald-50 dark:bg-emerald-900/20 backdrop-blur-xl p-4 transition-colors">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">✅</span>
                        <p class="flex-1 text-sm text-emerald-700 dark:text-emerald-200">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 rounded-2xl border border-red-400 dark:border-red-500/30 bg-red-50 dark:bg-red-900/20 backdrop-blur-xl p-4 transition-colors">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">❌</span>
                        <p class="flex-1 text-sm text-red-700 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
        @else
        <!-- Guest Content -->
        <div class="h-screen flex items-center justify-center">
            @yield('content')
        </div>
        @endauth
    </div>

    <!-- Scripts -->
    <script>
        // Mobile Sidebar Toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar on navigation (mobile)
        function closeMobileSidebarOnNavigate() {
            if (window.innerWidth < 1024) {
                toggleMobileSidebar();
            }
        }

        // Mobile menu button
        document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileSidebar);

        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = localStorage.getItem('theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            localStorage.setItem('theme', newTheme);

            if (newTheme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }

            updateThemeText();
        }

        // Update theme toggle text
        function updateThemeText() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const toggleText = document.getElementById('theme-toggle-text');
            if (toggleText) {
                toggleText.textContent = currentTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateThemeText();
        });
    </script>
</body>

</html>