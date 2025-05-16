<x-layout-admin>
    <x-slot:title>
        Thùng Rác contact
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Thùng Rác contact</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($contacts->isEmpty())
            <div class="text-gray-500">Không có contact nào trong thùng rác.</div>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Tên</th>
                        <th class="border border-gray-300 px-4 py-2">Trạng Thái</th>
                        <th class="border border-gray-300 px-4 py-2">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $contact->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $contact->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $contact->status == 1 ? 'Kích Hoạt' : 'Không Kích Hoạt' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="{{ route('admin.contact.restore', ['id' => $contact->id]) }}"
                                    class="text-blue-500 hover:underline">Khôi Phục</a>

                                <form
                                    action="{{ route('admin.contact.destroy', ['contact' => $contact->id, 'id' => $contact->id]) }}"
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
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</x-layout-admin>
