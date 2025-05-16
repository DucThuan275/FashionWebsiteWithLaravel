<x-layout-admin>
    <x-slot:title>
        Chi Tiết Đơn Hàng
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Xem thông tin chi tiết về đơn hàng</p>
                </div>
                <a href="{{ route('order.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay Lại
                </a>
            </div>

            <!-- Order Information Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Thông Tin Khách Hàng</h2>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tên khách hàng</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->phone }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Trạng thái</dt>
                            <dd class="mt-1">
                                @if ($order->status)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Hoàn thành
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Chưa hoàn thành
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Địa chỉ giao hàng</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->address }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Chi Tiết Sản Phẩm</h2>
                </div>
                <div class="px-6 py-4">
                    <div class="grid gap-6">
                        @foreach ($order->orderDetails as $detail)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Tên sản phẩm</div>
                                        <td class="border border-gray-300 px-4 py-2">{{ $detail->product->name }}</td>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Số lượng</div>
                                        <div class="mt-1 text-sm text-gray-900">{{ $detail->qty }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Đơn giá</div>
                                        <div class="mt-1 text-sm text-gray-900">
                                            {{ number_format($detail->price, 0, ',', '.') }} VNĐ</div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Giảm giá</div>
                                        <div class="mt-1 text-sm text-red-600">
                                            {{ number_format($detail->discount, 0, ',', '.') }} VNĐ</div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm font-medium text-gray-500">Thành tiền</div>
                                        <div class="text-lg font-medium text-green-600">
                                            {{ number_format($detail->amount, 0, ',', '.') }} VNĐ</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Tổng tiền đơn hàng -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-100">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Tổng tiền đơn hàng:</h3>
                    <span class="text-xl font-bold text-blue-600">
                        {{ number_format($order->orderDetails->sum('amount'), 0, ',', '.') }} VNĐ
                    </span>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
