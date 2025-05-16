<x-layout-admin>
    <x-slot:title>
        Cập Nhật Thương Hiệu
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Cập Nhật Thương Hiệu</h1>

        <!-- Form cập nhật thương hiệu -->
        <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label for="name" class="block font-medium">Tên Thương Hiệu</label>
                <input type="text" id="name" class="w-full border rounded p-2" name="name"
                    value="{{ old('name', $brand->name) }}" placeholder="Nhập tên thương hiệu">

                @if ($errors->has('name'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <!-- Hình ảnh -->
            <div class="mb-2">
                <label for="image" class="block font-medium">Hình Ảnh</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full border rounded p-2 {{ $errors->has('image') ? 'border-red-500' : '' }}">

                <!-- Hiển thị hình ảnh hiện tại -->
                @if ($brand->image)
                    <div class="mt-2">
                        <img src="{{ asset('images/brand/' . $brand->image) }}" alt="Hình hiện tại"
                            class="w-32 h-auto">
                    </div>
                @endif

                @if ($errors->has('image'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <!-- Mô tả -->
            <div class="mb-2">
                <label for="description" class="block font-medium">Mô Tả</label>
                <textarea id="description" name="description" rows="4" class="w-full border rounded p-2" placeholder="Nhập mô tả">{{ old('description', $brand->description) }}</textarea>
            </div>

            <!-- Thứ tự sắp xếp -->
            <div class="mb-2">
                <label for="sort_order" class="block font-medium">Thứ Tự Sắp Xếp</label>
                <input type="number" id="sort_order" name="sort_order" class="w-full border rounded p-2"
                    value="{{ old('sort_order', $brand->sort_order) }}" placeholder="Nhập thứ tự sắp xếp">
            </div>

            <!-- Trạng thái -->
            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select id="status" name="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Kích Hoạt</option>
                    <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Không Kích Hoạt
                    </option>
                </select>
            </div>

            <!-- Nút gửi -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>
