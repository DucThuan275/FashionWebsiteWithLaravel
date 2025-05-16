<x-layout-admin>
    <x-slot:title>
        Menu
    </x-slot:title>
    <x-slot:header>
    </x-slot:header>
    <div class="container mx-auto my-5">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Menu List</h1>
            <div class="flex space-x-4">
                <a href="{{ route('menu.create') }}"
                    class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Add
                </a>
                <a href="{{ route('admin.menu.trash') }}"
                    class="px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-gray active:bg-gray-600 transition duration-150 ease-in-out">
                    Trash Bin
                </a>
            </div>
        </div>

        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vị
                            Trí
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thứ
                            Tự
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng
                            Thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($menus as $menu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $menu->link }}" class="text-blue-500 hover:underline" target="_blank">
                                    {{ $menu->link }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $menu->sort_order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if ($menu->status)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" class="peer sr-only opacity-0"
                                            id="toggle-{{ $menu->id }}"
                                            onchange="window.location.href='{{ route('admin.menu.status', ['menu' => $menu->id, 'id' => $menu->id]) }}'"
                                            {{ $menu->status ? 'checked' : '' }} />
                                        <label for="toggle-{{ $menu->id }}"
                                            class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-400 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-green-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-green-500">
                                            <span class="sr-only">Activate/Deactivate</span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex justify-between gap-2">
                                    <!-- Show Button with Icon -->
                                    <a href="{{ route('menu.show', ['menu' => $menu->id]) }}"
                                        class="px-4 py-2 font-medium text-white bg-gray-600 rounded-md hover:bg-gray-500 focus:outline-none focus:shadow-outline-gray active:bg-gray-600 transition duration-150 ease-in-out w-full text-center">
                                        <i class="fas fa-eye"></i> <!-- Icon for Show -->
                                    </a>

                                    <!-- Edit Button with Icon -->
                                    <a href="{{ route('menu.edit', ['menu' => $menu->id]) }}"
                                        class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out w-full text-center">
                                        <i class="fas fa-edit"></i> <!-- Icon for Edit -->
                                    </a>

                                    <!-- Delete Button with Icon -->
                                    <a href="{{ route('admin.menu.delete', ['id' => $menu->id]) }}"
                                        class="px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out w-full text-center">
                                        <i class="fas fa-trash-alt"></i> <!-- Icon for Delete -->
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $menus->links() }}
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
