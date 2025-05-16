<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Admin Login</h2>

            <!-- Hiển thị thông báo lỗi nếu có -->
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form đăng nhập -->
            <form action="{{ route('admin.dologin') }}" method="POST">
                @csrf <!-- Bảo vệ CSRF -->

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="username" name="username"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                               @error('username') border-red-500 @enderror"
                        placeholder="Nhập email" required autofocus>
                    @error('username')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mật khẩu</label>
                    <input type="password" id="password" name="password"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                               @error('password') border-red-500 @enderror"
                        placeholder="Nhập mật khẩu" required>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-600">Ghi nhớ đăng nhập</span>
                        </label>
                    </div>
                    <a href="{{ route('admin.doforgotpassword') }}" class="text-sm text-blue-600 hover:underline">Quên
                        mật khẩu?</a>

                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                    Đăng nhập
                </button>
            </form>
        </div>
    </div>
</body>

</html>
