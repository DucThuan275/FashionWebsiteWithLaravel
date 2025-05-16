<x-layout-admin>
    <x-slot:title>
        Chi Tiết Thương Hiệu
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Chi Tiết Thương Hiệu</h1>

        <div class="space-y-4">
            <div class="mb-2">
                <label for="name" class="block font-medium">Tên Thương Hiệu</label>
                <p>{{ $brand->name }}</p>
            </div>

            <div class="mb-2">
                <label for="slug" class="block font-medium">Slug</label>
                <p>{{ $brand->slug }}</p>
            </div>

            <div class="mb-2">
                <label for="image" class="block font-medium">Hình Ảnh</label>
                @if ($brand->image)
                    <img src="{{ asset('storage/'.$brand->image) }}" alt="Hình ảnh thương hiệu" class="max-w-xs rounded">
                @else
                    <p>Không có hình ảnh.</p>
                @endif
            </div>

            <div class="mb-2">
                <label for="description" class="block font-medium">Mô Tả</label>
                <p>{{ $brand->description }}</p>
            </div>

            <div class="mb-2">
                <label for="sort_order" class="block font-medium">Thứ Tự Sắp Xếp</label>
                <p>{{ $brand->sort_order }}</p>
            </div>

            <div class="mb-2">
                <label for="created_by" class="block font-medium">Người Tạo</label>
                <p>{{ $brand->created_by }}</p>
            </div>

            <div class="mb-2">
                <label for="updated_by" class="block font-medium">Người Cập Nhật</label>
                <p>{{ $brand->updated_by }}</p>
            </div>

            <div class="mb-2">
                <label for="created_at" class="block font-medium">Ngày Tạo</label>
                <p>{{ $brand->created_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <div class="mb-2">
                <label for="updated_at" class="block font-medium">Ngày Cập Nhật</label>
                <p>{{ $brand->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <div class="mb-2">
                <label for="deleted_at" class="block font-medium">Ngày Xóa (Nếu Có)</label>
                <p>{{ $brand->deleted_at ? $brand->deleted_at->format('d/m/Y H:i:s') : 'Chưa bị xóa' }}</p>
            </div>

            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <p>{{ $brand->status == 1 ? 'Kích Hoạt' : 'Không Kích Hoạt' }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('brand.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Quay Lại
            </a>
        </div>
    </div>
</x-layout-admin>
