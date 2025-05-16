<x-layout-admin>
    <x-slot:title>
        Show Banner
    </x-slot:title>
    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết banner</h1>
            <div class="flex space-x-4">
                <a href="{{ route('banner.edit', ['banner' => $banner->id]) }}"
                    class="px-4 py-2 ml-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                    Edit
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full">
                <tbody>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $banner->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tên</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $banner->name }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Liên kết</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $banner->link }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Hình ảnh</th>
                        <td class="border border-gray-300 px-4 py-2">
                            <img src="{{ asset('images/banner/' . $banner->image) }}" alt="{{ $banner->name }}"
                                class="w-48 h-auto">
                        </td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Vị trí</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $banner->position }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $banner->status ? 'Hoạt động' : 'Không hoạt động' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('banner.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
