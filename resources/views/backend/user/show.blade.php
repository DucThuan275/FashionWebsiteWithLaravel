<x-layout-admin>
    <x-slot:title>
        Show User
    </x-slot:title>

    <x-slot:header>
    </x-slot:header>

    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Chi tiết người dùng</h1>
            <div class="flex space-x-4">
                <a href="{{ route('user.index') }}"
                    class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Quay lại danh sách
                </a>
                <a href="{{ route('user.edit', $user->id) }}"
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
                        <td class="border border-gray-300 px-4 py-2">{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Username</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->username }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Họ và tên</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->fullname }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Giới tính</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->gender ? 'Nam' : 'Nữ' }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Email</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Số điện thoại</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->phone }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Địa chỉ</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Vai trò</th>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->roles }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Trạng thái</th>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Ảnh đại diện</th>
                        <td class="border border-gray-300 px-4 py-2">
                            <img src="{{ asset('storage/' . $user->thumbnail) }}" alt="{{ $user->fullname }}"
                                class="w-20 h-20 object-cover rounded">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('user.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay
                lại danh sách</a>
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
