<x-layout-admin>
    <x-slot:title>
        Category
    </x-slot:title>
    <x-slot:header>
    </x-slot:header>
    <div class="container mx-auto my-5">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold mb-4">Category List</h1>
            <div class="flex space-x-4">
                <a href="{{ route('category.create') }}"
                    class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-green active:bg-green-600 transition duration-150 ease-in-out">
                    Add
                </a>
                <a href="{{ route('admin.category.trash') }}"
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categorys as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $category->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <img src="{{ asset('images/category/' . $category->image) }}"
                                    alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if ($category->status)
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
                                            id="toggle-{{ $category->id }}"
                                            onchange="window.location.href='{{ route('admin.category.status', ['category' => $category->id, 'id' => $category->id]) }}'"
                                            {{ $category->status ? 'checked' : '' }} />
                                        <label for="toggle-{{ $category->id }}"
                                            class="relative flex h-6 w-11 cursor-pointer items-center rounded-full bg-gray-400 px-0.5 outline-gray-400 transition-colors before:h-5 before:w-5 before:rounded-full before:bg-white before:shadow before:transition-transform before:duration-300 peer-checked:bg-green-500 peer-checked:before:translate-x-full peer-focus-visible:outline peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gray-400 peer-checked:peer-focus-visible:outline-green-500">
                                            <span class="sr-only">Activate/Deactivate</span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex justify-between gap-2">
                                    <!-- Show Button with Icon -->
                                    <a href="{{ route('category.show', ['category' => $category->id]) }}"
                                        class="px-4 py-2 font-medium text-white bg-gray-600 rounded-md hover:bg-gray-500 focus:outline-none focus:shadow-outline-gray active:bg-gray-600 transition duration-150 ease-in-out w-full text-center">
                                        <i class="fas fa-eye"></i> <!-- Icon for Show -->
                                    </a>

                                    <!-- Edit Button with Icon -->
                                    <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                        class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out w-full text-center">
                                        <i class="fas fa-edit"></i> <!-- Icon for Edit -->
                                    </a>

                                    <!-- Delete Button with Icon -->
                                    <a href="{{ route('admin.category.delete', ['id' => $category->id]) }}"
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
            {{ $categorys->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <x-slot:footer>
    </x-slot:footer>
</x-layout-admin>
