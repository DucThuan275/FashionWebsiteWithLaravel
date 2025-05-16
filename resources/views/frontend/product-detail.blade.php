<x-layout-site>
    <x-slot:title>
        Chi tiết sản phẩm
    </x-slot:title>

    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb cải tiến -->
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
                        <a href="{{ route('site.product') }}"
                            class="text-gray-600 hover:text-indigo-600 transition-colors">
                            Sản phẩm
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-medium">{{ $product->name }}</span>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                    <!-- Gallery Section -->
                    <div class="space-y-4">
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300">
                        </div>
                        <!-- Thumbnail navigation -->
                        <div class="grid grid-cols-4 gap-4">
                            <button class="aspect-square rounded-lg overflow-hidden border-2 border-indigo-600">
                                <img src="{{ asset('images/products/' . $product->thumbnail) }}" alt="Thumbnail 1"
                                    class="w-full h-full object-cover">
                            </button>
                            <!-- Additional thumbnail slots -->
                            {{-- @for ($i = 0; $i < 3; $i++)
                                <button
                                    class="aspect-square rounded-lg overflow-hidden border-2 border-transparent hover:border-indigo-600 transition-colors">
                                    <div class="w-full h-full bg-gray-100"></div>
                                </button>
                            @endfor --}}
                        </div>
                    </div>

                    <!-- Product Info Section -->
                    <div class="flex flex-col">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                            <!-- Price Section -->
                            <div class="flex items-baseline mb-6">
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ number_format($product->price_sale, 0, ',', '.') }} ₫
                                </p>
                                @if ($product->price_buy)
                                    <p class="ml-3 text-lg text-gray-500 line-through">
                                        {{ number_format($product->price_buy, 0, ',', '.') }} ₫
                                    </p>
                                    @if ($product->price_buy > $product->price_sale)
                                        <span
                                            class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            -{{ number_format((($product->price_buy - $product->price_sale) / $product->price_buy) * 100) }}%
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <!-- Product details -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Mã sản phẩm</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->id }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->content }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Mô tả sản phẩm</h3>
                                    <div class="mt-1 text-sm text-gray-500 space-y-2">
                                        {{ $product->description }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="mt-8 space-y-4">
                            <a href="{{ route('site.addcart', ['id' => $product->id]) }}"
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Thêm vào giỏ hàng
                            </a>

                            <button type="button"
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Thêm vào yêu thích
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <section class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :productitem="$relatedProduct" />
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-layout-site>
