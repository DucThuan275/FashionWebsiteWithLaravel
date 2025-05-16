<x-layout-site>
    <x-slot:title>
        Giỏ hàng
    </x-slot:title>

    <div class="bg-gray-100 h-screen py-8">
        <div class="container mx-auto items-center">
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
                        <span class="text-gray-800 font-medium">Giỏ hàng</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-4 text-center">Giỏ hàng của bạn</h1>

            @if (session('cart') && count(session('cart')) > 0)
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Product List -->
                    <div class="md:w-3/4">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-left font-semibold py-2">Sản phẩm</th>
                                        <th class="text-left font-semibold py-2">Giá</th>
                                        <th class="text-center font-semibold py-2">Số lượng</th>
                                        <th class="text-right font-semibold py-2">Tổng</th>
                                        <th class="text-center font-semibold py-2">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('cart') as $id => $item)
                                        <tr>
                                            <td class="py-4">
                                                <div class="flex items-center">
                                                    <img class="h-16 w-16 mr-4 rounded-md"
                                                        src="{{ 'images/products/' . $item['thumbnail'] }}"
                                                        alt="{{ $item['name'] }}">
                                                    <span class="font-semibold">{{ $item['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4">{{ number_format($item['price']) }}₫</td>
                                            <td class="py-4">
                                                <form action="{{ route('site.updatecart') }}" method="POST"
                                                    class="flex items-center justify-center">
                                                    @csrf
                                                    <button type="submit" name="qty[{{ $id }}]"
                                                        value="{{ $item['qty'] - 1 }}"
                                                        class="border rounded-md py-2 px-4">-</button>
                                                    <span class="text-center w-8">{{ $item['qty'] }}</span>
                                                    <button type="submit" name="qty[{{ $id }}]"
                                                        value="{{ $item['qty'] + 1 }}"
                                                        class="border rounded-md py-2 px-4">+</button>
                                                </form>

                                            </td>
                                            <td class="py-4 text-right">
                                                {{ number_format($item['price'] * $item['qty']) }}₫</td>
                                            <td class="py-4 text-center">
                                                <a href="{{ route('site.delcart', ['id' => $id]) }}"
                                                    class="text-red-500 hover:text-red-700">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- order descriptions -->
                    <div class="md:w-1/4">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Tóm tắt đơn hàng</h2>
                            <div class="flex justify-between mb-2">
                                <span>Tạm tính</span>
                                <span>{{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['qty'], session('cart')))) }}₫</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Tổng cộng</span>
                                <span>{{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['qty'], session('cart')))) }}₫</span>
                            </div>

                            <button id="showCheckoutFormBtn"
                                class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full text-center block">
                                Thanh toán
                            </button>
                            {{-- checkout form --}}
                            <div id="checkoutForm" style="display:none;">
                                <form action="{{ route('site.checkout') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700">Tên</label>
                                        <input type="text" name="name" id="name"
                                            class="w-full p-2 border rounded" required
                                            value="{{ Auth::user()->fullname }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="w-full p-2 border rounded" required
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Số điện
                                            thoại</label>
                                        <input type="text" name="phone" id="phone"
                                            class="w-full p-2 border rounded" required
                                            value="{{ Auth::user()->phone ?? '' }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Địa
                                            chỉ</label>
                                        <input type="text" name="address" id="address"
                                            class="w-full p-2 border rounded" required
                                            value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full text-center block">
                                        Thanh toán
                                    </button>
                                </form>
                            </div>

                            <script>
                                document.getElementById('showCheckoutFormBtn').addEventListener('click', function() {
                                    document.getElementById('showCheckoutFormBtn').style.display = 'none';
                                    document.getElementById('checkoutForm').style.display = 'block';
                                });
                            </script>

                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('site.home') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Tiếp tục mua sắm</a>
                    <a href="{{ route('site.delcart') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Xóa toàn bộ</a>
                </div>
            @else
                <p class="text-gray-600 text-center">Giỏ hàng của bạn hiện đang trống.</p>
                <div class="mt-6 text-center">
                    <a href="{{ route('site.home') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tiếp tục mua sắm</a>
                </div>
            @endif
        </div>
    </div>
</x-layout-site>
