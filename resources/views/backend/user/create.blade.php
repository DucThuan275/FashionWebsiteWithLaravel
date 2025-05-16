<x-layout-admin>
    <x-slot:title>
        Tạo Người Dùng
    </x-slot:title>

    <div class="container mx-auto mt-4">
        <h1 class="text-xl font-bold mb-4">Tạo Người Dùng</h1>

        <!-- Form tạo người dùng -->
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Username -->
            <div class="mb-2">
                <label for="username">Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" class="w-full" value="{{ old('username') }}">

                @error('username')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-2">
                <label for="password">Mật Khẩu</label>
                <input type="password" id="password" name="password" class="w-full">

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

            <!-- Fullname -->
            <div class="mb-2">
                <label for="fullname">Họ Tên</label>
                <input type="text" id="fullname" name="fullname" class="w-full" value="{{ old('fullname') }}">

                @error('fullname')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-2">
                <label for="gender" class="block font-medium">Giới Tính</label>
                <select id="gender" name="gender" class="w-full border rounded p-2">
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>

            <!-- Thumbnail -->
            <div class="mb-2">
                <label for="thumbnail" class="block font-medium">Ảnh Đại Diện</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="w-full border rounded p-2">

                @error('thumbnail')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-2">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="w-full" value="{{ old('email') }}">

                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-2">
                <label for="phone">Số Điện Thoại</label>
                <input type="text" id="phone" name="phone" class="w-full" value="{{ old('phone') }}">

                @error('phone')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-2">
                <label for="address">Địa Chỉ</label>
                <input type="text" id="address" name="address" class="w-full" value="{{ old('address') }}">

                @error('address')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Roles -->
            <div class="mb-2">
                <label for="roles" class="block font-medium">Vai Trò</label>
                <select id="roles" name="roles" class="w-full border rounded p-2">
                    <option value="admin" {{ old('roles') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ old('roles') == 'customer' ? 'selected' : '' }}>Khách Hàng</option>
                </select>
            </div>

            <!-- Status -->
            <div class="mb-2">
                <label for="status" class="block font-medium">Trạng Thái</label>
                <select id="status" name="status" class="w-full border rounded p-2">
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Kích Hoạt</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không Kích Hoạt</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>
