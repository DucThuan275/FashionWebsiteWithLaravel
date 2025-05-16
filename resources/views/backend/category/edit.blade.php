<!-- resources/views/admin/categories/edit.blade.php -->

<x-layout-admin>
    <x-slot:title>
        Sửa Danh Mục
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Sửa Danh Mục</h1>

        <!-- Form sửa danh mục -->
        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Tên danh mục -->
            <div class="mb-2">
                <label for="name" class="block font-medium">Tên Danh Mục</label>
                <input type="text" id="name" class="w-full border rounded p-2" name="name"
                    value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục">

                @if ($errors->has('name'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <!-- Danh mục cha -->
            <div class="mb-2">
                <label for="parent_id" class="block font-medium">Danh Mục Cha</label>
                <select id="parent_id" name="parent_id" class="w-full border rounded p-2">
                    <option value="0" {{ old('parent_id', $category->parent_id) == 0 ? 'selected' : '' }}>
                        Chọn danh mục cha (nếu có)
                    </option>
                    @foreach ($categorys as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('parent_id'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('parent_id') }}</div>
                @endif
            </div>

            <!-- Hình ảnh -->
            <div class="mb-2">
                <label for="image" class="block font-medium">Hình Ảnh</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full border rounded p-2">

                @if ($errors->has('image'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</div>
                @endif
                @if ($category->image)
                    <div class="mt-2">
                        <img src="{{ asset('images/category/' . $category->image) }}" alt="Image"
                            class="w-32 h-32 object-cover">
                    </div>
                @endif
            </div>

            <!-- Mô tả -->
            <div class="mb-2">
                <label for="description" class="block font-medium">Mô Tả</label>
                <textarea id="description" name="description" rows="4" class="w-full border rounded p-2" placeholder="Nhập mô tả">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Thứ tự sắp xếp -->
            <div class="mb-2">
                <label for="sort_order" class="block font-medium">Thứ Tự Sắp Xếp</label>
                <input type="number" id="sort_order" name="sort_order" class="w-full border rounded p-2"
                    value="{{ old('sort_order', $category->sort_order) }}" placeholder="Nhập thứ tự sắp xếp">
            </div>

            <!-- Trạng thái -->
            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select id="status" name="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Kích Hoạt
                    </option>
                    <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Không Kích
                        Hoạt</option>
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
