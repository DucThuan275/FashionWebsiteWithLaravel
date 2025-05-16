<x-layout-site>
    <x-slot:title>
        Thông Tin Người Dùng
    </x-slot:title>

    <div class="container mx-auto mt-8 p-6 bg-cover rounded-lg shadow-2xl bg-opacity-75"
        style="background-image:url('https://img.freepik.com/vector-gratis/fondo-marco-geometrico-vector-diseno-moderno-verde_53876-157567.jpg?w=900&t=st=1688168789~exp=1688169389~hmac=5a24574ea11605b3e307bac515167587e5d13f5e163695f27a55c4f37ba03127');">
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
                    <span class="text-gray-800 font-medium">Thông tin người dùng</span>
                </li>
            </ol>
        </nav>
        <div class="flex flex-wrap items-center justify-center lg:justify-start">
            <!-- Thông tin người dùng -->
            <div
                class="w-full lg:w-3/5 rounded-lg shadow-xl bg-white opacity-75 mx-6 lg:mx-0 p-8 text-center lg:text-left">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Thông Tin Cá Nhân</h1>
                    <div class="w-4/5 mx-auto lg:mx-0 pt-3 border-b-2 border-green-500 opacity-25"></div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <strong class="text-gray-700">Họ Tên:</strong>
                        <span class="text-gray-600">{{ $user->fullname }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <strong class="text-gray-700">Email:</strong>
                        <span class="text-gray-600">{{ $user->email }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <strong class="text-gray-700">Giới Tính:</strong>
                        <span class="text-gray-600">{{ ucfirst($user->gender) }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <strong class="text-gray-700">Số Điện Thoại:</strong>
                        <span class="text-gray-600">{{ $user->phone ?? 'Không có số điện thoại' }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <strong class="text-gray-700">Địa Chỉ:</strong>
                        <span class="text-gray-600">{{ $user->address ?? 'Chưa cập nhật' }}</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-center gap-4 py-8">
                    <a href="{{ route('site.editprofile') }}"
                        class="flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow-md hover:bg-green-800 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12l4.243-4.243a4 4 0 10-5.657-5.657L9 6"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 6l-3 3m0 0L3 9m3-3v12a3 3 0 003 3h12"></path>
                        </svg>
                        Cập Nhật Thông Tin
                    </a>
                    <a href="{{ route('site.order') }}"
                        class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h11M9 21h6a2 2 0 002-2V7a2 2 0 00-2-2h-6"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7l-2 2m0 0l2 2m-2-2h12"></path>
                        </svg>
                        Xem Đơn Hàng
                    </a>
                </div>

            </div>

            <!-- Ảnh người dùng -->
            <div class="w-full lg:w-2/5">
                @if ($user->thumbnail)
                    <img src="{{ asset('images/user/' . $user->thumbnail) }}" alt="Thumbnail"
                        class="rounded-lg shadow-2xl w-full lg:w-80 mx-auto">
                @else
                    <span class="text-gray-600">Chưa có ảnh đại diện</span>
                @endif
            </div>
        </div>
    </div>
</x-layout-site>
