<x-layout-admin>
    <x-slot:title>
        Show Contact
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết liên hệ</h1>
            <div class="flex space-x-4">
                <a href="{{ route('contact.edit', $contact->id) }}"
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
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tên</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->name }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Số điện thoại</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->phone }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Tiêu đề</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->title }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Nội dung</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->content }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Người gửi</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $contact->user_id }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $contact->status ? 'Đã xử lý' : 'Chưa xử lý' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('contact.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
