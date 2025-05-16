<x-layout-site>
    <x-slot:title>
        Chi tiết sản phẩm
    </x-slot:title>

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-8">
                <!-- Breadcrumb -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center text-sm text-gray-500">
                        <li>
                            <a href="{{ route('site.home') }}" class="hover:text-indigo-600 transition-colors">
                                Trang chủ
                            </a>
                        </li>
                        <li class="mx-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </li>
                        <li class="text-gray-900 font-medium">
                            Kết quả tìm kiếm
                        </li>
                    </ol>
                </nav>

                <!-- Search Header -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Kết quả tìm kiếm</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Hiển thị kết quả cho "<span class="font-medium">{{ $search }}</span>"
                    </p>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="container mx-auto px-4 py-8">
            <!-- Results Count -->
            <p class="text-sm text-gray-600 mb-6">
                Tìm thấy <span class="font-medium text-gray-900">{{ count($products) }}</span> kết quả
            </p>

            @if (count($products) > 0)
                <!-- Products Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8">
                    @foreach ($products as $product)
                        <x-product-card :productitem="$product" />
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                        Không tìm thấy sản phẩm
                    </h3>
                    <p class="text-gray-500">
                        Vui lòng thử lại với từ khóa khác
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layout-site>
