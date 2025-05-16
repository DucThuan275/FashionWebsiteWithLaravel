<x-layout-site>
    <x-slot:title>
        Sản phẩm
    </x-slot:title>

    <div class="container mx-auto p-6 md:p-8">
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
                    <span class="text-gray-800 font-medium">Tất cả sản phẩm</span>
                </li>
            </ol>
        </nav>
        <!-- Main Content -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Sidebar (Brand & Category) -->
            <div class="col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                    <!-- Brand Section -->
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800">Thương hiệu</h3>
                            <span class="text-xs text-gray-400">{{ count($brands) }} brands</span>
                        </div>
                        <div class="space-y-1">
                            @foreach ($brands as $brand)
                                <a href="{{ route('site.product', array_merge(request()->except('page', 'category'), ['brand' => $brand->slug])) }}"
                                    class="group flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i
                                            class="fa-regular fa-building text-gray-400 group-hover:text-blue-500 transition-colors duration-200"></i>
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-200">
                                            {{ $brand->name }}
                                        </span>
                                    </div>
                                    <i
                                        class="fa-solid fa-chevron-right text-xs text-gray-300 group-hover:text-blue-500 transition-colors duration-200"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Section -->
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800">Danh mục</h3>
                            <span class="text-xs text-gray-400">{{ count($categories) }} categories</span>
                        </div>
                        <div class="space-y-1">
                            @foreach ($categories as $category)
                                <a href="{{ route('site.product', array_merge(request()->except('page', 'brand'), ['category' => $category->slug])) }}"
                                    class="group flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i
                                            class="fa-regular fa-folder text-gray-400 group-hover:text-blue-500 transition-colors duration-200"></i>
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-200">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                    <i
                                        class="fa-solid fa-chevron-right text-xs text-gray-300 group-hover:text-blue-500 transition-colors duration-200"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Products Section -->
            <div class="col-span-10 space-y-6">
                <!-- Advanced Filter Panel -->
                <form id="filter-form" method="GET" action="{{ route('site.product') }}"
                    class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <input type="hidden" name="view" value="{{ request('view', 'grid') }}">

                    <!-- Top Control Bar -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <!-- View Toggle -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-600">Hiển thị:</span>
                                <div class="flex gap-2 bg-gray-50 p-1 rounded-lg">
                                    <button type="button" id="grid-view" aria-selected="true"
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-md text-gray-600 hover:bg-white hover:shadow-sm transition-all duration-200 aria-selected:bg-yellow-500 aria-selected:text-white">
                                        <i class="fa-solid fa-th-large text-sm"></i>
                                    </button>
                                    <button type="button" id="list-view" aria-selected="false"
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-md text-gray-600 hover:bg-white hover:shadow-sm transition-all duration-200 aria-selected:bg-yellow-500 aria-selected:text-white">
                                        <i class="fa-solid fa-list text-sm"></i>
                                    </button>

                                </div>
                            </div>


                            <!-- Sort Dropdown -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-600">Sắp xếp:</span>
                                <select name="sort_by"
                                    class="text-sm bg-gray-50 border-0 rounded-lg px-4 py-2 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    onchange="this.form.submit()">
                                    <option value="">Mặc định</option>
                                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>
                                        Giá thấp đến cao</option>
                                    <option value="price_desc"
                                        {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp
                                    </option>
                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới
                                        nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <div class="p-4 space-y-4">
                        <!-- Search and Dropdowns Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Enhanced Search Input -->
                            <div class="relative">
                                <input type="text" name="search" value="{{ old('search', $search) }}"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-0 rounded-lg text-gray-600 placeholder-gray-400 text-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    placeholder="Tìm kiếm sản phẩm...">
                                <i class="fa-solid fa-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                            </div>

                            <!-- Brand Dropdown -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('brandDropdown')"
                                    class="w-full px-4 py-2.5 bg-gray-50 rounded-lg text-sm text-gray-600 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 text-left">
                                    <div class="flex justify-between items-center">
                                        <span>Thương hiệu</span>
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </button>
                                <div id="brandDropdown"
                                    class="absolute z-20 hidden w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-100 max-h-64 overflow-y-auto">
                                    <div class="p-2">
                                        @foreach ($brands as $brand)
                                            <label
                                                class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors duration-200">
                                                <input type="checkbox" name="brand[]" value="{{ $brand->slug }}"
                                                    {{ in_array($brand->slug, (array) request('brand')) ? 'checked' : '' }}
                                                    class="rounded-sm border-gray-300 text-blue-500 focus:ring-blue-500">
                                                <span class="text-sm text-gray-600">{{ $brand->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Category Dropdown -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('categoryDropdown')"
                                    class="w-full px-4 py-2.5 bg-gray-50 rounded-lg text-sm text-gray-600 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 text-left">
                                    <div class="flex justify-between items-center">
                                        <span>Danh mục</span>
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </button>
                                <div id="categoryDropdown"
                                    class="absolute z-20 hidden w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-100 max-h-64 overflow-y-auto">
                                    <div class="p-2">
                                        @foreach ($categories as $category)
                                            <label
                                                class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors duration-200">
                                                <input type="checkbox" name="category[]"
                                                    value="{{ $category->slug }}"
                                                    {{ in_array($category->slug, (array) request('category')) ? 'checked' : '' }}
                                                    class="rounded-sm border-gray-300 text-blue-500 focus:ring-blue-500">
                                                <span class="text-sm text-gray-600">{{ $category->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Range Sliders -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <label class="text-sm font-medium text-gray-600">Giá từ:</label>
                                    <span id="price_min_value"
                                        class="text-sm font-medium text-blue-500">{{ number_format(old('price_min', request('price_min', 0))) }}₫</span>
                                </div>
                                <input type="range" name="price_min" id="price_min" min="0" max="10000000"
                                    step="500000" value="{{ old('price_min', request('price_min', 0)) }}"
                                    class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer"
                                    onchange="updatePriceRange()">
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <label class="text-sm font-medium text-gray-600">Giá đến:</label>
                                    <span id="price_max_value"
                                        class="text-sm font-medium text-blue-500">{{ number_format(old('price_max', request('price_max', 10000000))) }}₫</span>
                                </div>
                                <input type="range" name="price_max" id="price_max" min="0" max="10000000"
                                    step="500000" value="{{ old('price_max', request('price_max', 10000000)) }}"
                                    class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer"
                                    onchange="updatePriceRange()">
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if (request('brand') || request('category') || request('price_min') || request('price_max'))
                            <div class="flex flex-wrap gap-2 pt-4" id="selected-filters">
                                @foreach ((array) request('brand') as $brandSlug)
                                    @php $brand = $brands->firstWhere('slug', $brandSlug); @endphp
                                    @if ($brand)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-medium">
                                            {{ $brand->name }}
                                            <button type="button"
                                                onclick="removeSpecificFilter('brand', '{{ $brandSlug }}')"
                                                class="ml-1 text-blue-400 hover:text-blue-600 transition-colors duration-200">
                                                <i class="fa-solid fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                @endforeach

                                @foreach ((array) request('category') as $categorySlug)
                                    @php $category = $categories->firstWhere('slug', $categorySlug); @endphp
                                    @if ($category)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-600 rounded-full text-sm font-medium">
                                            {{ $category->name }}
                                            <button type="button"
                                                onclick="removeSpecificFilter('category', '{{ $categorySlug }}')"
                                                class="ml-1 text-green-400 hover:text-green-600 transition-colors duration-200">
                                                <i class="fa-solid fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                @endforeach

                                @if (request('price_min') || request('price_max'))
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-sm font-medium">
                                        Giá: {{ number_format(request('price_min')) }}₫ -
                                        {{ number_format(request('price_max')) }}₫
                                        <button type="button" onclick="removeFilter('price')"
                                            class="ml-1 text-yellow-400 hover:text-yellow-600 transition-colors duration-200">
                                            <i class="fa-solid fa-times text-xs"></i>
                                        </button>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 rounded-b-xl flex justify-end gap-3">
                        <button type="button" id="clear-filters"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fa-solid fa-times-circle mr-1.5"></i>Bỏ lọc
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fa-solid fa-filter mr-1.5"></i>Áp dụng
                        </button>
                    </div>
                </form>

                <!-- Section Title -->
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Tất cả sản phẩm
                        <span class="text-lg font-medium text-gray-500">({{ $products->total() }} sản phẩm)</span>
                    </h1>
                </div>


                <!-- Product Grid -->
                <div id="product-list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @include('frontend.partials.product_list', ['products' => $products])
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="flex justify-center mt-8" id="pagination">
                        {{ $products->appends(request()->except('page'))->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll("button[aria-selected]");

            buttons.forEach((button) => {
                button.addEventListener("click", () => {
                    buttons.forEach((btn) => btn.setAttribute("aria-selected", "false"));
                    button.setAttribute("aria-selected", "true");
                });
            });
            // DOM Elements
            const elements = {
                productList: document.getElementById('product-list'),
                listViewBtn: document.getElementById('list-view'),
                gridViewBtn: document.getElementById('grid-view'),
                filterForm: document.getElementById('filter-form'),
                clearFiltersBtn: document.getElementById('clear-filters'),
                priceMinInput: document.getElementById('price_min'),
                priceMaxInput: document.getElementById('price_max'),
                priceMinValue: document.getElementById('price_min_value'),
                priceMaxValue: document.getElementById('price_max_value')
            };

            // View Management
            class ViewManager {
                constructor() {
                    this.urlParams = new URLSearchParams(window.location.search);
                    this.initializeView();
                    this.bindViewEvents();
                }

                initializeView() {
                    const viewMode = this.urlParams.get('view') || 'grid';
                    viewMode === 'list' ? this.setListView() : this.setGridView();
                }

                bindViewEvents() {
                    elements.listViewBtn.addEventListener('click', () => {
                        this.setListView();
                        this.updateURL('list');
                    });

                    elements.gridViewBtn.addEventListener('click', () => {
                        this.setGridView();
                        this.updateURL('grid');
                    });
                }

                setListView() {
                    elements.productList.classList.replace('grid', 'block');
                    elements.productList.querySelectorAll('.product-card').forEach(card => {
                        card.classList.add('flex', 'items-center');
                        card.querySelector('img').classList.add('w-40', 'h-40');
                        card.querySelector('.p-4').classList.add('ml-4');
                    });
                }

                setGridView() {
                    elements.productList.classList.replace('block', 'grid');
                    elements.productList.classList.add('grid-cols-1', 'sm:grid-cols-2', 'md:grid-cols-3',
                        'lg:grid-cols-4');
                    elements.productList.querySelectorAll('.product-card').forEach(card => {
                        card.classList.remove('flex', 'items-center');
                        card.querySelector('img').classList.remove('w-40', 'h-40');
                        card.querySelector('.p-4').classList.remove('ml-4');
                    });
                }

                updateURL(view) {
                    this.urlParams.set('view', view);
                    window.history.replaceState({}, '',
                        `${window.location.pathname}?${this.urlParams.toString()}`);
                }
            }

            // Filter Management
            class FilterManager {
                constructor() {
                    this.bindFilterEvents();
                    this.initializePriceRange();
                }

                bindFilterEvents() {
                    elements.clearFiltersBtn.addEventListener('click', () => this.clearAllFilters());
                    elements.priceMinInput.addEventListener('input', () => this.updatePriceRange());
                    elements.priceMaxInput.addEventListener('input', () => this.updatePriceRange());

                    // Bind remove filter buttons
                    document.querySelectorAll('#selected-filters button').forEach(button => {
                        button.addEventListener('click', () => {
                            const filterType = this.getFilterType(button.parentElement);
                            this.removeFilter(filterType);
                        });
                    });
                }

                getFilterType(element) {
                    if (element.classList.contains('bg-blue-100')) return 'brand';
                    if (element.classList.contains('bg-green-100')) return 'category';
                    return 'price';
                }

                updatePriceRange() {
                    let priceMin = parseInt(elements.priceMinInput.value);
                    let priceMax = parseInt(elements.priceMaxInput.value);

                    if (priceMin > priceMax) {
                        priceMin = priceMax;
                        elements.priceMinInput.value = priceMin;
                    }
                    if (priceMax < priceMin) {
                        priceMax = priceMin;
                        elements.priceMaxInput.value = priceMax;
                    }

                    elements.priceMinValue.textContent = this.formatCurrency(priceMin);
                    elements.priceMaxValue.textContent = this.formatCurrency(priceMax);
                }

                formatCurrency(value) {
                    return value.toLocaleString('vi-VN') + '₫';
                }

                removeFilter(filterType) {
                    const urlParams = new URLSearchParams(window.location.search);

                    if (filterType === 'price') {
                        urlParams.delete('price_min');
                        urlParams.delete('price_max');
                    } else {
                        urlParams.delete(`${filterType}[]`);
                    }

                    this.updateURLAndReload(urlParams);
                }

                clearAllFilters() {
                    window.history.replaceState({}, '', window.location.pathname);
                    location.reload();
                }

                updateURLAndReload(urlParams) {
                    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                    location.reload();
                }

                initializePriceRange() {
                    this.updatePriceRange();
                }
            }

            // Dropdown Management
            class DropdownManager {
                constructor() {
                    this.initializeDropdowns();
                }

                initializeDropdowns() {
                    document.addEventListener('click', (event) => this.handleOutsideClick(event));

                    // Prevent dropdown from closing when clicking checkboxes
                    document.querySelectorAll('[id$="Dropdown"] input[type="checkbox"]').forEach(checkbox => {
                        checkbox.addEventListener('click', (e) => e.stopPropagation());
                    });
                }

                toggleDropdown(dropdownId) {
                    const dropdown = document.getElementById(dropdownId);
                    const allDropdowns = document.querySelectorAll('[id$="Dropdown"]');

                    allDropdowns.forEach(d => {
                        if (d.id !== dropdownId && !d.classList.contains('hidden')) {
                            d.classList.add('hidden');
                        }
                    });

                    dropdown.classList.toggle('hidden');
                }

                handleOutsideClick(event) {
                    const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
                    const buttons = document.querySelectorAll('[onclick^="toggleDropdown"]');

                    if (!this.isClickInsideDropdowns(event.target, dropdowns, buttons)) {
                        dropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
                    }
                }

                isClickInsideDropdowns(target, dropdowns, buttons) {
                    return [...dropdowns, ...buttons].some(element => element.contains(target));
                }
            }

            // Initialize all managers
            const viewManager = new ViewManager();
            const filterManager = new FilterManager();
            const dropdownManager = new DropdownManager();

            // Expose necessary functions globally
            window.toggleDropdown = (dropdownId) => dropdownManager.toggleDropdown(dropdownId);
            window.removeFilter = (filterType) => filterManager.removeFilter(filterType);
            window.removeSpecificFilter = (filterType, value) => {
                const urlParams = new URLSearchParams(window.location.search);
                let currentValues = urlParams.getAll(filterType + '[]');

                currentValues = currentValues.filter(v => v !== value);
                urlParams.delete(filterType + '[]');

                currentValues.forEach(v => urlParams.append(filterType + '[]', v));
                filterManager.updateURLAndReload(urlParams);
            };
        });
    </script>
</x-layout-site>
