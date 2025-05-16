<x-layout-admin>
    <x-slot:title>
        Chi Tiết Sản Phẩm
    </x-slot:title>

    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900">Chi Tiết Sản Phẩm</h1>
                <p class="mt-1 text-sm text-gray-500">ID: #{{ $product->id }} • Cập nhật lần cuối:
                    {{ $product->updated_at }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại
                </a>
                <a href="{{ route('product.edit', $product->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Chỉnh sửa
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Image and Status -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="aspect-w-1 aspect-h-1 w-full">
                            @if ($product->thumbnail)
                                <img src="{{ asset('images/products/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 rounded-lg">
                                    <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500">Trạng thái</span>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium {{ $product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status ? 'Đang hoạt động' : 'Ngừng hoạt động' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <!-- Basic Info Section -->
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tên sản phẩm</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $product->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Slug</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $product->slug }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Danh mục</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Thương hiệu</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $product->brand->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Price Info Section -->
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Thông tin giá</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Giá bán</label>
                                    <p class="mt-1 text-lg font-semibold text-blue-600">
                                        {{ number_format($product->price_buy, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Giá khuyến mãi</label>
                                    <p class="mt-1 text-lg font-semibold text-green-600">
                                        {{ number_format($product->price_sale, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Mô tả sản phẩm</h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 whitespace-pre-line">
                                    {{ $product->description ?: 'Chưa có mô tả' }}</p>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Thông tin bổ sung</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Số lượng trong kho</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $product->qty }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Ngày tạo</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $product->created_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>
