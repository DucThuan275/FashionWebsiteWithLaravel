<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Trang Quản Trị' }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" sizes="32x32" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
        integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    {{ $header ?? '' }}
</head>

<body class="flex flex-col min-h-screen">
    @include('components.alert')
    <div class="flex flex-1">
        <aside class="bg-blue-600 text-white w-64 p-4 min-h-fit">
            <div class="flex justify-between items-center mb-6">
                <a href="/" class="text-xl font-bold">Admin Panel</a>
            </div>
            <nav>
                <ul class="space-y-6">
                    <!-- Dashboard -->
                    <li>
                        <a href={{ route('admin.dashboard') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Banner -->
                    <li>
                        <a href={{ route('banner.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-image mr-3"></i>
                            Banner
                        </a>
                    </li>

                    <!-- Brand -->
                    <li>
                        <a href={{ route('brand.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-cogs mr-3"></i>
                            Brand
                        </a>
                    </li>

                    <!-- Category -->
                    <li>
                        <a href={{ route('category.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-th-list mr-3"></i>
                            Category
                        </a>
                    </li>

                    <!-- Contact -->
                    <li>
                        <a href={{ route('contact.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-address-book mr-3"></i>
                            Contact
                        </a>
                    </li>

                    <!-- Menu -->
                    <li>
                        <a href={{ route('menu.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-bars mr-3"></i>
                            Menu
                        </a>
                    </li>

                    <!-- Order -->
                    <li>
                        <a href={{ route('order.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-box mr-3"></i>
                            Order
                        </a>
                    </li>

                    <!-- Product -->
                    <li>
                        <a href={{ route('product.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-cogs mr-3"></i>
                            Product
                        </a>
                    </li>

                    <!-- Topic -->
                    <li>
                        <a href="{{ route('topic.index') }}"
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-clipboard-list mr-3"></i> <!-- Thay đổi thành fa-clipboard-list -->
                            Topic
                        </a>
                    </li>

                    <!-- Post -->
                    <li>
                        <a href="{{ route('post.index') }}"
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-pen mr-3"></i> <!-- Thay đổi thành fa-pen -->
                            Post
                        </a>
                    </li>

                    <!-- User -->
                    <li>
                        <a href={{ route('user.index') }}
                            class="flex items-center text-lg text-white hover:text-gray-300">
                            <i class="fas fa-users mr-3"></i>
                            User
                        </a>
                    </li>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button class="flex items-center text-lg text-white hover:text-gray-300 mt-auto">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </ul>
            </nav>

        </aside>

        <main class="flex-1 p-6">
            {{ $slot ?? '' }}
        </main>
    </div>

    <footer class="bg-gray-800 text-white py-4 w-full mt-auto">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} Trang quản trị.</p>
            <p>Designed by Võ Đức Thuận</p>
        </div>
    </footer>

    {{ $footer ?? '' }}
</body>

</html>
