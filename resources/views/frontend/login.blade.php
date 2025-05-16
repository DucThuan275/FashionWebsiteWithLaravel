<x-layout-site>
    <x-slot:title>
        Đăng nhập
    </x-slot:title>
    <div class="container mx-auto items-center p-5">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('site.home') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </li>
                <li>
                    <span class="text-gray-800 font-medium">Đăng nhập</span>
                </li>
            </ol>
        </nav>
    </div>
    <!-- Login Form Section -->
    <div class="container mx-auto flex justify-center items-center p-10">

        <div class="grid md:grid-cols-2 grid-cols-1 w-full bg-white rounded-3xl shadow-lg">
            <!-- Left Side: Login Form -->
            <div class="flex justify-center items-center p-8">
                <form action="{{ route('site.dologin') }}" method="POST" class="w-full max-w-sm">
                    <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Đăng nhập</h2>

                    <!-- Display error or success message -->
                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    @csrf
                    <div class="mb-6">
                        <label for="username" class="block text-gray-700 font-medium mb-2">Tên đăng nhập hoặc
                            Email</label>
                        <input type="text" id="username" name="username"
                            class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Nhập tên đăng nhập hoặc email" required autofocus>
                        @error('username')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Mật khẩu</label>
                        <input type="password" id="password" name="password"
                            class="w-full bg-gray-100 border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Nhập mật khẩu" required>
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-600">Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="#" class="text-sm text-indigo-600 hover:underline">Quên mật khẩu?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-md font-semibold hover:bg-indigo-700 transition duration-200">
                        Đăng nhập
                    </button>
                </form>
            </div>

            <!-- Right Side: Image Section -->
            <div class="flex justify-center items-center p-8">
                <img src="https://img.freepik.com/premium-vector/vector-abstract-seamless-pattern-with-stars-blue-background_117177-1008.jpg"
                    class="rounded-3xl shadow-lg" alt="Abstract pattern">
            </div>
        </div>
    </div>
</x-layout-site>
