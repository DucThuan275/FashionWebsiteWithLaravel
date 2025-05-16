<x-layout-site>
    <x-slot:title>
        Chỉnh Sửa Thông Tin
    </x-slot:title>

    <div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg m-2">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('site.home') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </li>
                <li>
                    <span class="text-gray-800 font-medium">Chỉnh sủa người dùng</span>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Chỉnh Sửa Thông Tin Cá Nhân</h1>

        <form action="{{ route('profile.update', ['userId' => Auth::id()]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <!-- Chia form thành 2 cột -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Họ Tên -->
                <div class="mb-6">
                    <label for="fullname" class="block text-gray-700">Họ Tên</label>
                    <input type="text" id="fullname" name="fullname" class="w-full border rounded p-2"
                        value="{{ old('fullname', $user->fullname) }}">
                    @error('fullname')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full border rounded p-2"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số Điện Thoại -->
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700">Số Điện Thoại</label>
                    <input type="text" id="phone" name="phone" class="w-full border rounded p-2"
                        value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Địa Chỉ -->
                <div class="mb-6">
                    <label for="address" class="block text-gray-700">Địa Chỉ</label>
                    <input type="text" id="address" name="address" class="w-full border rounded p-2"
                        value="{{ old('address', $user->address) }}">
                    @error('address')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giới Tính -->
                <div class="mb-6">
                    <label for="gender" class="block text-gray-700">Giới Tính</label>
                    <select id="gender" name="gender" class="w-full border rounded p-2">
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam
                        </option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ
                        </option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác
                        </option>
                    </select>
                </div>

                <!-- Ảnh Đại Diện -->
                <div class="mb-6">
                    <label for="thumbnail" class="block text-gray-700">Ảnh Đại Diện</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                        class="w-full border rounded p-2">
                    @error('thumbnail')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    @if ($user->thumbnail)
                        <div class="mt-2">
                            <img src="{{ asset('images/user/' . $user->thumbnail) }}" alt="Thumbnail"
                                class="w-24 h-24 object-cover rounded-full">
                        </div>
                    @endif
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lưu Thay
                    Đổi</button>
            </div>
        </form>
    </div>
</x-layout-site>
