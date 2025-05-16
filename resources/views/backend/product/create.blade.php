<x-layout-admin>
    <x-slot:title>
        Tạo Sản Phẩm Mới
    </x-slot:title>
    <!-- Tom Select CDN for enhanced dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- IMask for price formatting -->
    <script src="https://unpkg.com/imask"></script>
    <!-- TinyMCE CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tom Select for dropdowns
            new TomSelect('#category_id', {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                render: {
                    option: function(data, escape) {
                        return `<div class="py-2 px-3 hover:bg-gray-100">
                            <div class="font-medium">${escape(data.text)}</div>
                        </div>`;
                    }
                }
            });

            new TomSelect('#brand_id', {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                }
            });

            // Initialize IMask for price inputs
            const priceOptions = {
                mask: Number,
                scale: 0,
                thousandsSeparator: '.',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.']
            };

            IMask(document.getElementById('price_buy'), priceOptions);
            IMask(document.getElementById('price_sale'), priceOptions);

            // Slug generation from product name
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/đ/g, 'd')
                    .replace(/[^a-z0-9-]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.value = slug;
            });

            // Character counter for product name
            nameInput.addEventListener('input', function() {
                const remainingChars = 255 - this.value.length;
                document.getElementById('nameCounter').textContent = `${remainingChars} ký tự còn lại`;
            });
        });

        // Price validation
        function validatePrices() {
            const priceBuy = parseFloat(document.getElementById('price_buy').value.replace(/\./g, ''));
            const priceSale = parseFloat(document.getElementById('price_sale').value.replace(/\./g, ''));

            if (priceSale >= priceBuy) {
                document.getElementById('priceError').classList.remove('hidden');
                return false;
            }
            document.getElementById('priceError').classList.add('hidden');
            return true;
        }
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            skin: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'oxide-dark' : 'oxide',
            content_css: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default'
        });

        // Initialize TinyMCE for description
        tinymce.init({
            selector: '#description',
            plugins: 'autoresize lists',
            toolbar: 'bold italic | bullist numlist | removeformat',
            menubar: false,
            height: 200,
        });

        // Image Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <div class="container mx-auto px-4 py-8">
        <div class="container mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tạo Sản Phẩm Mới</h1>
                <p class="mt-2 text-gray-600">Điền đầy đủ thông tin để tạo sản phẩm mới</p>
            </div>

            <!-- Form -->
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-lg shadow-lg p-6">
                @csrf

                <!-- Grid Layout for Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Tên Sản Phẩm -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Tên Sản Phẩm</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('name') }}" placeholder="Nhập tên sản phẩm" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Danh Mục & Thương Hiệu -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh
                                    Mục</label>
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="brand_id" class="block text-sm font-medium text-gray-700">Thương
                                    Hiệu</label>
                                <select id="brand_id" name="brand_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Giá & Số Lượng -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price_buy" class="block text-sm font-medium text-gray-700">Giá Bán</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" id="price_buy" name="price_buy"
                                        class="block w-full rounded-md border-gray-300 pr-12 focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('price_buy') }}" placeholder="0" required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">VNĐ</span>
                                    </div>
                                </div>
                                @error('price_buy')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price_sale" class="block text-sm font-medium text-gray-700">Giá Khuyến
                                    Mãi</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" id="price_sale" name="price_sale"
                                        class="block w-full rounded-md border-gray-300 pr-12 focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('price_sale') }}" placeholder="0" required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">VNĐ</span>
                                    </div>
                                </div>
                                @error('price_sale')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Số Lượng & Trạng Thái -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="qty" class="block text-sm font-medium text-gray-700">Số Lượng</label>
                                <input type="number" id="qty" name="qty"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('qty') }}" placeholder="0" required>
                                @error('qty')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Trạng Thái</label>
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Kích Hoạt
                                    </option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không Kích Hoạt
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hình Ảnh -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hình Ảnh Sản Phẩm</label>
                            <div class="mt-1 flex items-center">
                                <div class="w-full">
                                    <label class="block">
                                        <span class="sr-only">Choose product photo</span>
                                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            onchange="previewImage(this)">
                                    </label>
                                </div>
                            </div>
                            <div id="image-preview-container" class="hidden mt-3">
                                <img id="image-preview" class="h-32 w-32 object-cover rounded-lg" src="#"
                                    alt="Preview">
                            </div>
                            @error('thumbnail')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Mô Tả Ngắn -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô Tả
                                Ngắn</label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Nhập mô tả ngắn về sản phẩm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nội Dung Chi Tiết -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Nội Dung Chi
                                Tiết</label>
                            <textarea id="content" name="content"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <button type="button" onclick="window.history.back()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Hủy
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tạo Sản Phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout-admin>
