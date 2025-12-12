<x-guest-layout>
    <!-- Dark mode script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-slate-950 transition-colors duration-200 px-4 sm:px-6 lg:px-8">
        <!-- Subtle gradient background -->
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_#22c55e11,_transparent_60%),_radial-gradient(circle_at_bottom,_#0ea5e911,_transparent_55%)] dark:bg-[radial-gradient(circle_at_top,_#22c55e22,_transparent_60%),_radial-gradient(circle_at_bottom,_#0ea5e922,_transparent_55%)]"></div>

        <div class="relative w-full max-w-md">
            <!-- Theme Toggle Button -->
            <div class="absolute -top-16 right-0">
                <button onclick="toggleTheme()" class="p-2 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors" title="Toggle theme">
                    <svg id="theme-icon-sun" class="hidden dark:block w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="theme-icon-moon" class="block dark:hidden w-5 h-5 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
            </div>

            <!-- Login Card -->
            <div class="rounded-3xl border border-gray-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl shadow-2xl shadow-gray-300/20 dark:shadow-emerald-500/10 p-8 sm:p-10 transition-colors">
                
                <!-- Logo & Title -->
                <div class="flex flex-col items-center mb-8">
                    <div class="h-12 px-2 rounded-xl bg-emerald-500/90 flex items-center justify-center shadow-lg shadow-emerald-500/40 mb-4">
                        <span class="text-2xl font-black tracking-tight text-white">Bentoda Store</span>
                    </div>
                    <h2 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-slate-50">Welcome back</h2>
                    <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">Sign in to your admin account</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-slate-300" />
                        <x-text-input 
                            id="email" 
                            class="mt-2 block w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="admin@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600 dark:text-red-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700 dark:text-slate-300" />
                        <x-text-input 
                            id="password" 
                            class="mt-2 block w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800/50 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600 dark:text-red-400" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="w-4 h-4 rounded border-gray-300 dark:border-slate-700 text-emerald-500 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 dark:bg-slate-800 transition-colors" 
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-slate-400">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-emerald-300 font-medium transition-colors" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button class="w-full justify-center px-5 py-3 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/40 transition-all duration-200 hover:shadow-emerald-500/50">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-800 text-center">
                    <p class="text-xs text-gray-500 dark:text-slate-500">
                        Mini Grocery Store POS & Inventory System
                    </p>
                    <p class="text-xs text-gray-400 dark:text-slate-600 mt-1">
                        Built with Laravel · Tailwind CSS · MySQL
                    </p>
                </div>
            </div>


        </div>
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
</x-guest-layout>
