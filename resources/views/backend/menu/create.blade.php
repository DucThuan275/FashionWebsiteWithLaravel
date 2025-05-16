<x-layout-admin>
    <x-slot:title>
        Tạo Menu
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Tạo Menu</h1>

        <!-- Form tạo menu -->
        <form action="{{ route('menu.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="mb-2">
                <label for="name" class="block font-medium">Tên Menu</label>
                <input type="text" id="name" name="name" class="w-full border rounded p-2"
                    value="{{ old('name') }}" placeholder="Nhập tên menu">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="link" class="block font-medium">Link</label>
                <input type="text" id="link" name="link" class="w-full border rounded p-2"
                    value="{{ old('link') }}" placeholder="Nhập link menu">
                @error('link')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="parent_id" class="block font-medium">Menu Cha</label>
                <select name="parent_id" id="parent_id" class="w-full border rounded p-2">
                    <!-- Option cho menu cha với giá trị mặc định là 0 -->
                    <option value="0" {{ old('parent_id', 0) == 0 ? 'selected' : '' }}>Không có menu cha</option>
                    @foreach ($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', 0) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-2">
                <label for="type" class="block font-medium">Loại Menu</label>
                <input type="text" id="type" name="type" class="w-full border rounded p-2"
                    value="{{ old('type') }}" placeholder="Nhập loại menu (ví dụ: post, page)">
                @error('type')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="position" class="block font-medium">Vị trí Menu</label>
                <select name="position" id="position" class="w-full border rounded p-2">
                    <option value="" disabled selected>Chọn vị trí menu</option>
                    @foreach ($positions as $key => $value)
                        <option value="{{ $key }}" {{ old('position') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
                @error('position')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-2">
                <label for="table_id" class="block font-medium">Bảng Liên Kết</label>
                <select name="table_id" id="table_id" class="w-full border rounded p-2">
                    <option value="" disabled selected>Chọn bảng</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                            {{ $table->name }}
                        </option>
                    @endforeach
                </select>
                @error('table_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select name="status" id="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không kích hoạt</option>
                </select>
                @error('status')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="sort_order" class="block font-medium">Thứ tự</label>
                <input type="number" id="sort_order" name="sort_order" class="w-full border rounded p-2"
                    value="{{ old('sort_order', 1) }}" placeholder="Nhập thứ tự sắp xếp">
                @error('sort_order')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lưu</button>
            </div>
        </form>
    </div>
</x-layout-admin>
