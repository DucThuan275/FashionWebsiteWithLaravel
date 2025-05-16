<x-layout-admin>
    <x-slot:title>
        Show Topic
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết chủ đề</h1>
            <div class="flex space-x-4">
                <a href="{{ route('topic.index') }}"
                    class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Quay lại danh sách
                </a>
                <a href="{{ route('topic.edit', $topic->id) }}"
                    class="px-4 py-2 font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Sửa
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full">
                <tbody>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tên chủ đề</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic->name }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Slug</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic->slug }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Mô tả</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic->description }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Thứ tự sắp xếp</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $topic->sort_order }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $topic->status ? 'Hoạt động' : 'Không hoạt động' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('topic.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay
                lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
