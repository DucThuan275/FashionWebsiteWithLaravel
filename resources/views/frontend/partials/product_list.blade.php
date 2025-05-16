@forelse ($products as $product)
    <!-- Bố cục Flexbox: Hình ảnh bên trái, Thông tin sản phẩm bên phải -->
    <div
        class="product-card bg-white shadow-lg rounded-lg overflow-hidden flex w-full mb-6 transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">

        <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}" class="relative">
            <img src="{{ asset('images/products/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                class="w-full h-[350px] object-cover group-hover:scale-105 transition-transform duration-500">
            @if ($product->price_buy && $product->price_sale < $product->price_buy)
                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-medium px-2 py-1 rounded">
                    -{{ round((($product->price_buy - $product->price_sale) / $product->price_buy) * 100) }}%
                </span>
            @endif
        </a>
        <!-- Thông tin sản phẩm -->
        <div class="p-4 flex flex-col flex-1">
            <h3 class="text-base font-semibold text-gray-800 hover:text-blue-600 transition-colors duration-200 mb-2">
                <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
                    {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                </a>
            </h3>
            <p class="text-gray-600 text-sm mt-2">{{ \Illuminate\Support\Str::limit($product->content, 100) }}</p>
            <div class="flex justify-between items-center mt-4">
                <span class="text-lg font-bold text-yellow-600">
                    {{ number_format($product->price_sale, 0, ',', '.') }}₫
                </span>
                @if ($product->price_buy)
                    <span class="text-sm text-gray-400 line-through ml-2">
                        {{ number_format($product->price_buy, 0, ',', '.') }}₫
                    </span>
                @endif
            </div>

            <!-- Các nút (Xem chi tiết, Thêm vào giỏ) -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}"
                    class="text-blue-500 text-sm font-medium hover:underline">
                    Xem chi tiết
                </a>
                <a href="{{ route('site.addcart', ['id' => $product->id, 'view' => request('view', 'grid')]) }}"
                    class="text-2xl text-blue-500 hover:text-blue-600 ml-4">
                    <i class="fa-solid fa-cart-plus"></i>
                </a>
            </div>
        </div>
    </div>

@empty
    <p>Không có sản phẩm nào phù hợp.</p>
@endforelse
