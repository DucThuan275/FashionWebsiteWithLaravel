<x-layout-admin>
    <x-slot:title>
        Order Management
    </x-slot:title>

    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Quản Lý Đơn Hàng</h1>
                    <p class="mt-1 text-sm text-gray-500">Xem và quản lý tất cả đơn hàng</p>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow mb-6">
                <form action="{{ route('order.index') }}" method="GET" class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Tìm theo mã đơn, tên, email, số điện thoại..."
                                class="w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <select name="status"
                                class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Chờ xử lý
                                </option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoàn thành
                                </option>
                            </select>
                        </div>

                        <!-- Sort Direction -->
                        <div>
                            <select name="direction"
                                class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                onchange="this.form.submit()">
                                <option value="DESC" {{ request('direction') != 'ASC' ? 'selected' : '' }}>Mới nhất
                                </option>
                                <option value="ASC" {{ request('direction') == 'ASC' ? 'selected' : '' }}>Cũ nhất
                                </option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div>
                            <a href="{{ route('order.index') }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Đặt lại
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Orders List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    <a href="{{ route(
                                        'order.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'id',
                                            'direction' => request('direction') == 'ASC' ? 'DESC' : 'ASC',
                                        ]),
                                    ) }}"
                                        class="group inline-flex items-center">
                                        ID
                                        @if (request('sort') == 'id')
                                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ request('direction') == 'ASC' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Thông tin khách hàng
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    <a href="{{ route(
                                        'order.index',
                                        array_merge(request()->query(), [
                                            'sort' => 'status',
                                            'direction' => request('direction') == 'ASC' ? 'DESC' : 'ASC',
                                        ]),
                                    ) }}"
                                        class="group inline-flex items-center">
                                        Trạng thái
                                        @if (request('sort') == 'status')
                                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ request('direction') == 'ASC' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Tổng tiền
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" x-data="{ expandedOrder: null }">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $order->status == '1' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $order->status == '1' ? 'Hoàn thành' : 'Chờ xử lý' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($order->orderdetails->sum('amount'), 0, ',', '.') }} VNĐ
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <!-- Actions -->
                                        <div class="px-4 py-3 flex justify-end space-x-2">
                                            <a href="{{ route('order.show', $order->id) }}"
                                                class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Chi tiết
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

</x-layout-admin>
