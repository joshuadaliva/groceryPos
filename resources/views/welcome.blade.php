<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mini Grocery POS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dark mode script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="antialiased bg-slate-950  text-slate-900 dark:text-slate-100 transition-colors duration-200">
    <div class="min-h-screen flex flex-col">

        {{-- Top navigation --}}
        <header class="w-full border-b border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-950/80 backdrop-blur transition-colors duration-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-xl bg-emerald-500/90 flex items-center justify-center shadow-lg shadow-emerald-500/40">
                        <span class="text-xl font-black tracking-tight text-white">G</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-tight text-gray-900 dark:text-slate-50">Mini Grocery Store</p>
                        <p class="text-[11px] text-gray-600 dark:text-slate-400">POS & Inventory Management</p>
                    </div>
                </div>

                <nav class="hidden sm:flex items-center gap-6 text-sm text-gray-600 dark:text-slate-300">
                    <a href="#features" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition">Features</a>
                    <a href="#how-it-works" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition">How it works</a>
                    <a href="#tech" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition">Tech stack</a>
                </nav>

                <div class="flex items-center gap-3">
                    <!-- Theme Toggle Button -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors" title="Toggle theme">
                        <svg id="theme-icon-sun" class="hidden dark:block w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="theme-icon-moon" class="block dark:hidden w-5 h-5 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    @auth
                    <a href="{{ route('dashboard') }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-900 dark:text-slate-100 border border-gray-300 dark:border-slate-700/80 transition-colors">
                        Open dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition">
                        Sign in as admin
                    </a>
                    @endauth
                </div>
            </div>
        </header>

        {{-- Hero section --}}
        <main class="flex-1 bg-white dark:bg-slate-950 transition-colors duration-200">
            <section class="relative overflow-hidden">
                {{-- subtle gradient background --}}
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_#22c55e11,_transparent_60%),_radial-gradient(circle_at_bottom,_#0ea5e911,_transparent_55%)] dark:bg-[radial-gradient(circle_at_top,_#22c55e22,_transparent_60%),_radial-gradient(circle_at_bottom,_#0ea5e922,_transparent_55%)]"></div>

                <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
                    {{-- Left: text --}}
                    <div>
                        <p class="inline-flex items-center gap-2 text-xs font-medium px-3 py-1 rounded-full border border-emerald-400/40 bg-emerald-500/10 text-emerald-600 dark:text-emerald-300 mb-5 transition-colors">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Mini Grocery POS & Inventory
                        </p>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-gray-900 dark:text-slate-50 transition-colors">
                            Manage your grocery<br class="hidden sm:block">
                            <span class="text-emerald-500 dark:text-emerald-400">faster and smarter.</span>
                        </h1>

                        <p class="mt-4 text-sm sm:text-base text-gray-600 dark:text-slate-300/90 max-w-xl transition-colors">
                            A lightweight Point of Sale and Inventory Management system
                            for small grocery stores. Scan barcodes, track stock in real‑time,
                            and see your sales at a glance.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition">
                                Go to dashboard
                            </a>
                            @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition">
                                Sign in as admin
                            </a>
                            @endauth

                            <span class="text-xs text-gray-500 dark:text-slate-400 transition-colors">
                                Built with Laravel · Tailwind CSS · MySQL
                            </span>
                        </div>

                        <div id="features" class="mt-10 grid sm:grid-cols-3 gap-4 text-xs sm:text-sm">
                            <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/70 p-4 transition-colors">
                                <p class="text-emerald-600 dark:text-emerald-300 font-semibold mb-1">Smart POS</p>
                                <p class="text-gray-600 dark:text-slate-400">Scan barcodes, build a cart, and auto‑generate change and receipts.</p>
                            </div>
                            <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/70 p-4 transition-colors">
                                <p class="text-emerald-600 dark:text-emerald-300 font-semibold mb-1">Live inventory</p>
                                <p class="text-gray-600 dark:text-slate-400">Stocks update automatically after each sale with low‑stock alerts.</p>
                            </div>
                            <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/70 p-4 transition-colors">
                                <p class="text-emerald-600 dark:text-emerald-300 font-semibold mb-1">Sales dashboard</p>
                                <p class="text-gray-600 dark:text-slate-400">See total sales, transactions, and top products in one dashboard.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Right: "glass" preview card --}}
                    <div class="lg:pl-4">
                        <div class="relative">
                            <div class="absolute -top-8 -right-6 h-24 w-24 rounded-full bg-emerald-500/20 blur-3xl"></div>

                            <div class="rounded-3xl border border-gray-200 dark:border-slate-800/80 bg-white dark:bg-slate-900/70 backdrop-blur-xl shadow-2xl shadow-gray-300/20 dark:shadow-emerald-500/15 p-5 sm:p-6 space-y-4 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Today's sales</p>
                                        <p class="text-xl font-semibold text-gray-900 dark:text-slate-50">₱12,540.00</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 transition-colors">
                                        +18% vs yesterday
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-3 text-[11px]">
                                    <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/60 p-3 transition-colors">
                                        <p class="text-gray-500 dark:text-slate-400">Transactions</p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-slate-50">42</p>
                                    </div>
                                    <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/60 p-3 transition-colors">
                                        <p class="text-gray-500 dark:text-slate-400">Items sold</p>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-slate-50">189</p>
                                    </div>
                                    <div class="rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/60 p-3 transition-colors">
                                        <p class="text-gray-500 dark:text-slate-400">Low stock</p>
                                        <p class="mt-1 text-lg font-semibold text-amber-600 dark:text-amber-300">6</p>
                                    </div>
                                </div>

                                <div class="mt-3 rounded-xl border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-900/60 p-3 transition-colors">
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400 mb-2">Top products</p>
                                    <div class="space-y-1.5 text-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 dark:text-slate-200">Lucky Me Pancit Canton</span>
                                            <span class="text-gray-500 dark:text-slate-400">32 sold</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 dark:text-slate-200">Coke 1.5L</span>
                                            <span class="text-gray-500 dark:text-slate-400">24 sold</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 dark:text-slate-200">Rice 5kg</span>
                                            <span class="text-gray-500 dark:text-slate-400">17 sold</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-gray-200 dark:border-slate-800 mt-2 flex items-center justify-between text-[11px] text-gray-500 dark:text-slate-400 transition-colors">
                                    <div>
                                        <p>Store: <span class="text-gray-900 dark:text-slate-200 font-medium">Mini Grocery</span></p>
                                        <p class="mt-0.5">Location: <span class="text-gray-900 dark:text-slate-200">Pili, Cam. Sur</span></p>
                                    </div>
                                    <div class="text-right">
                                        <p>Built with Laravel</p>
                                        <p class="mt-0.5">Tailwind · MySQL</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- simple footer --}}
            <footer id="tech" class="border-t border-gray-200 dark:border-slate-800/80 bg-white dark:bg-slate-950/95 transition-colors">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-gray-500 dark:text-slate-500">
                    <p>© {{ date('Y') }} Mini Grocery Store POS & Inventory System.</p>
                    <p>Made with Laravel, Tailwind CSS, and JavaScript barcode scanning.</p>
                </div>
            </footer>
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
            } else {
                html.classList.remove('dark');
            }
        }
    </script>
</body>

</html>