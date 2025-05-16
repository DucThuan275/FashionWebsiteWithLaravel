<x-layout-admin>
    <x-slot:title>
        Thùng Rác brand
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Thùng Rác brand</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($brands->isEmpty())
            <div class="text-gray-500">Không có brand nào trong thùng rác.</div>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Tên</th>
                        <th class="border border-gray-300 px-4 py-2">Hình Ảnh</th>
                        <th class="border border-gray-300 px-4 py-2">Trạng Thái</th>
                        <th class="border border-gray-300 px-4 py-2">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $brand->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $brand->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                @if ($brand->image)
                                    <img src="{{ asset('images/brand/' . $brand->image) }}" alt="brand Image"
                                        class="w-16 h-auto">
                                @else
                                    Không có hình
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $brand->status == 1 ? 'Kích Hoạt' : 'Không Kích Hoạt' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="{{ route('admin.brand.restore', ['id' => $brand->id]) }}"
                                    class="text-blue-500 hover:underline">Khôi Phục</a>

                                <form
                                    action="{{ route('admin.brand.destroy', ['brand' => $brand->id, 'id' => $brand->id]) }}"
                                    method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Xóa Vĩnh Viễn</button>
                                </form>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        @endif
    </div>
</x-layout-admin>
