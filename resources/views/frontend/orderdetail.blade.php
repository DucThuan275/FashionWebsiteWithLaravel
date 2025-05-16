<x-layout-site>
    <x-slot:title>Chi Tiết Đơn Hàng #{{ $order->id }}</x-slot:title>

    <div class="min-h-screen bg-gray-50">
        <!-- Main Container -->
        <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('site.home') }}"
                            class="text-gray-600 hover:text-indigo-600 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-800 ml-1 md:ml-2 font-medium">Chi tiết đơn hàng</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Order Status Banner -->
            <div class="bg-white rounded-lg shadow-sm mb-6 p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div
                        class="rounded-full h-12 w-12 flex items-center justify-center
                        {{ $order->status == 1 ? 'bg-green-100' : 'bg-yellow-100' }}">
                        <svg class="h-6 w-6 {{ $order->status == 1 ? 'text-green-600' : 'text-yellow-600' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {{ $order->status == 1
                                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>' }}
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-500">Trạng thái:
                            <span class="font-medium {{ $order->status == 1 ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $order->status == 1 ? 'Đã giao hàng' : 'Đang xử lý' }}
                            </span>
                        </p>
                    </div>
                </div>
                <a href="{{ route('site.order') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Customer Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Thông tin khách hàng
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Họ tên</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Địa chỉ giao hàng</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->address }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Chi tiết sản phẩm</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                @foreach ($order->orderDetails as $detail)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="sm:flex sm:items-center sm:justify-between">
                                            <div class="sm:flex sm:items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="h-20 w-20 object-cover rounded-lg"
                                                        src="{{ asset('images/products/' . $detail->product->thumbnail) }}"
                                                        alt="{{ $detail->product->name }}">
                                                </div>
                                                <div class="mt-4 sm:mt-0 sm:ml-4">
                                                    <h4 class="text-base font-medium text-gray-900">
                                                        {{ $detail->product->name }}
                                                    </h4>
                                                    <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                                        <span>Số lượng: {{ $detail->qty }}</span>
                                                        <span>•</span>
                                                        <span>Đơn giá: {{ number_format($detail->price, 0, ',', '.') }}
                                                            VNĐ</span>
                                                    </div>
                                                    @if ($detail->discount > 0)
                                                        <div class="mt-1 text-sm text-red-600">
                                                            Giảm giá:
                                                            -{{ number_format($detail->discount, 0, ',', '.') }} VNĐ
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-4 sm:mt-0">
                                                <p class="text-base font-medium text-gray-900">
                                                    {{ number_format($detail->amount, 0, ',', '.') }} VNĐ
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Summary -->
                            <div class="mt-8 border-t border-gray-200 pt-8">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-base font-medium text-gray-900">Tổng tiền hàng</dt>
                                        <dd class="text-base font-medium text-gray-900">
                                            {{ number_format($order->orderDetails->sum('amount'), 0, ',', '.') }} VNĐ
                                        </dd>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                        <dt class="text-lg font-bold text-gray-900">Tổng thanh toán</dt>
                                        <dd class="text-lg font-bold text-blue-600">
                                            {{ number_format($order->orderDetails->sum('amount'), 0, ',', '.') }} VNĐ
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-site>
