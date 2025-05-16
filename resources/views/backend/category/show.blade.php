<x-layout-admin>
    <x-slot:title>
        Show Category
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết danh mục</h1>
            <div class="flex space-x-4">
                <a href="{{ route('category.edit', $category->id) }}"
                    class="px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Edit
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full">
                <tbody>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tên</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Slug</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Mô tả</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->description }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Vị trí sắp xếp</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->sort_order }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Hình ảnh</th>
                        <td class="border border-gray-300 px-4 py-2">
                            <img src="{{ asset('images/category/' . $category->image) }}" alt="{{ $category->name }}"
                                class="w-48 h-auto">
                        </td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Danh mục cha</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->parent_name ?? 'Không có' }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $category->status ? 'Hoạt động' : 'Không hoạt động' }}
                        </td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Ngày tạo</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->created_at->format('d/m/Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('category.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
