<x-layout-admin>
    <x-slot:title>
        Trả Lời Contact
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Trả Lời Contact: {{ $contact->name }}</h1>

        <!-- Form trả lời -->
        <form action="{{ route('admin.contact.reply.store', $contact->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('POST') <!-- Nếu sử dụng POST, hoặc PUT nếu bạn muốn cập nhật -->

            <!-- Nội dung phản hồi -->
            <div class="mb-2">
                <label for="reply_content" class="block font-medium">Nội Dung Phản Hồi</label>
                <textarea id="reply_content" name="reply_content" rows="4" class="w-full border rounded p-2"
                    placeholder="Nhập nội dung phản hồi">{{ old('reply_content') }}</textarea>

                @if ($errors->has('reply_content'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('reply_content') }}</div>
                @endif
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Gửi Phản Hồi
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>
