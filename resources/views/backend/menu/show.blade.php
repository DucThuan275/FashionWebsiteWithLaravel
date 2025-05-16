<x-layout-admin>
    <x-slot:title>
        Show Menu
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết menu</h1>
            <div class="flex space-x-4">
                <a href="{{ route('menu.edit', $menu->id) }}"
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
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tên</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->name }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Liên kết</th>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ $menu->link }}" class="text-blue-500 hover:underline" target="_blank">
                                {{ $menu->link }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Loại</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->type }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Vị trí</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->position }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Bảng ID</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->table_id }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Menu Cha</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->parent_id ? 'Có' : 'Không' }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Thứ tự</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $menu->sort_order }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $menu->status ? 'Kích hoạt' : 'Vô hiệu' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('menu.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay
                lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
