<x-layout-admin>
    <x-slot:title>
        Tạo Bài Viết
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Tạo Bài Viết</h1>

        <!-- Form tạo bài viết -->
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Tiêu đề -->
            <div class="mb-2">
                <label for="title" class="block font-medium">Tiêu Đề</label>
                <input type="text" id="title" class="w-full border rounded p-2" name="title"
                    value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết">

                @if ($errors->has('title'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('title') }}</div>
                @endif
            </div>

            <!-- Chủ đề -->
            <div class="mb-2">
                <label for="topic_id" class="block font-medium">Chủ Đề</label>
                <select id="topic_id" name="topic_id" class="w-full border rounded p-2">
                    <option value="">Chọn chủ đề</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('topic_id'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('topic_id') }}</div>
                @endif
            </div>

            <!-- Type -->
            <div class="mb-2">
                <label for="type" class="block font-medium">Loại Bài Viết</label>
                <select id="type" name="type" class="w-full border rounded p-2">
                    <option value="post" {{ old('type') == 'post' ? 'selected' : '' }}>Bài Viết</option>
                    <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Trang</option>
                </select>
            </div>

            <!-- Nội dung -->
            <div class="mb-2">
                <label for="content" class="block font-medium">Nội Dung</label>
                <textarea id="content" name="content" rows="4" class="w-full border rounded p-2"
                    placeholder="Nhập nội dung bài viết">{{ old('content') }}</textarea>

                @if ($errors->has('content'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('content') }}</div>
                @endif
            </div>

            <!-- Mô tả -->
            <div class="mb-2">
                <label for="description" class="block font-medium">Mô Tả</label>
                <textarea id="description" name="description" rows="4" class="w-full border rounded p-2"
                    placeholder="Nhập mô tả ngắn cho bài viết">{{ old('description') }}</textarea>
            </div>

            <!-- Hình ảnh -->
            <div class="mb-2">
                <label for="thumbnail" class="block font-medium">Hình Ảnh</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="w-full border rounded p-2 {{ $errors->has('thumbnail') ? 'border-red-500' : '' }}">

                @if ($errors->has('thumbnail'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('thumbnail') }}</div>
                @endif
            </div>

            <!-- Trạng thái -->
            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select id="status" name="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Kích Hoạt</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không Kích Hoạt</option>
                </select>
            </div>

            <!-- Nút gửi -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>
