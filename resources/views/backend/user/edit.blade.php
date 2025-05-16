<x-layout-admin>
    <x-slot:title>
        Chỉnh Sửa Người Dùng
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Chỉnh Sửa Người Dùng</h1>

        <!-- Form chỉnh sửa người dùng -->
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tên Đăng Nhập -->
            <div class="mb-4">
                <label for="username" class="block font-medium">Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" class="w-full border rounded p-2"
                    value="{{ old('username', $user->username) }}">

                @error('username')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mật Khẩu -->
            <div class="mb-4">
                <label for="password" class="block font-medium">Mật Khẩu</label>
                <input type="password" id="password" name="password" class="w-full border rounded p-2">

                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-2">
                <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full">

                @error('password_confirmation')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Họ Tên -->
            <div class="mb-4">
                <label for="fullname" class="block font-medium">Họ Tên</label>
                <input type="text" id="fullname" name="fullname" class="w-full border rounded p-2"
                    value="{{ old('fullname', $user->fullname) }}">

                @error('fullname')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Giới Tính -->
            <div class="mb-4">
                <label for="gender" class="block font-medium">Giới Tính</label>
                <select id="gender" name="gender" class="w-full border rounded p-2">
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                </select>

                @error('gender')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ảnh Đại Diện -->
            <div class="mb-4">
                <label for="thumbnail" class="block font-medium">Ảnh Đại Diện</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="w-full border rounded p-2">

                @if ($user->thumbnail)
                    <div class="mt-2">
                        <img src="{{ asset('images/user/' . $user->thumbnail) }}" alt="User Thumbnail"
                            class="w-24 h-24 rounded-full object-cover">
                    </div>
                @endif

                @error('thumbnail')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full border rounded p-2"
                    value="{{ old('email', $user->email) }}">

                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Số Điện Thoại -->
            <div class="mb-4">
                <label for="phone" class="block font-medium">Số Điện Thoại</label>
                <input type="text" id="phone" name="phone" class="w-full border rounded p-2"
                    value="{{ old('phone', $user->phone) }}">

                @error('phone')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Địa Chỉ -->
            <div class="mb-4">
                <label for="address" class="block font-medium">Địa Chỉ</label>
                <input type="text" id="address" name="address" class="w-full border rounded p-2"
                    value="{{ old('address', $user->address) }}">

                @error('address')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Vai Trò -->
            <div class="mb-4">
                <label for="roles" class="block font-medium">Vai Trò</label>
                <select id="roles" name="roles" class="w-full border rounded p-2">
                    <option value="admin" {{ old('roles', $user->roles) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ old('roles', $user->roles) == 'customer' ? 'selected' : '' }}>Khách
                        Hàng</option>
                </select>

                @error('roles')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Trạng Thái -->
            <div class="mb-4">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select id="status" name="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Kích Hoạt
                    </option>
                    <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Không Kích Hoạt
                    </option>
                </select>

                @error('status')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>
