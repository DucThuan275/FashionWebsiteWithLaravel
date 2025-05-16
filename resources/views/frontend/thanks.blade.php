<x-layout-site>
    <x-slot:title>
        Giỏ hàng
    </x-slot:title>

    <div class="container mx-auto px-4 md:px-6 py-12">
        <!-- Thank You Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">

            <!-- Hình ảnh thanh toán thành công với animation -->
            <div class="mb-6">
                <img src="https://cdn-icons-png.flaticon.com/512/11055/11055673.png" alt="Thanh toán thành công"
                    class="mx-auto w-32 h-32 rounded-full animate-bounce">
            </div>

            <!-- Tiêu đề cảm ơn -->
            <h2 class="text-3xl font-bold text-green-600 mb-4">
                Thanh toán thành công!
            </h2>
            <p class="text-lg text-gray-600 mb-6">
                Cảm ơn bạn đã hoàn tất thanh toán. Chúng tôi sẽ xử lý đơn hàng và thông báo khi có thông tin mới.
            </p>

            <!-- Nút trở về trang chủ -->
            <a href="{{ route('site.home') }}"
                class="inline-block bg-blue-600 text-white text-lg font-semibold py-3 px-6 rounded-md shadow hover:bg-blue-700 transition duration-300 ease-in-out">
                Trở về trang chủ
            </a>
        </div>
    </div>

</x-layout-site>
