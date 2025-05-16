<header class="bg-white dark:bg-gray-900 shadow-lg fixed top-0 left-0 w-full z-50">
    <nav class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center space-x-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="h-10 w-auto">
                    <span
                        class="ml-3 text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Oni Fashion
                    </span>
                </div>

                <!-- Search Section -->
                <div class="hidden lg:block flex-1 max-w-xl">
                    <form action="{{ route('site.searchResults') }}" method="GET" class="relative">
                        <input type="text" name="search"
                            class="w-full px-5 py-2.5 text-sm text-indigo-200 bg-gray-50 dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200"
                            placeholder="Tìm kiếm sản phẩm..." value="{{ old('search', request('search')) }}">
                        <button type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            <x-main-menu />
            <!-- Actions Section -->
            <div class="flex items-center space-x-6">
                @if (Auth::check())
                    <!-- Logged in state -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('site.profile') }}"
                            class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 transition">
                            <i class="fa-solid fa-user text-lg"></i>
                            <span class="text-sm font-medium">{{ Auth::user()->fullname }}</span>
                        </a>

                        <form action="{{ route('site.logout') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Login/Register buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('site.login') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('site.register') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fa-regular fa-registered mr-2"></i>
                            <span>Register</span>
                        </a>
                    </div>
                @endif

                <!-- Cart -->
                <a href="{{ route('site.cart') }}"
                    class="relative p-2 text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    <span
                        class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ auth()->check() && session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </div>
        </div>

    </nav>
</header>
