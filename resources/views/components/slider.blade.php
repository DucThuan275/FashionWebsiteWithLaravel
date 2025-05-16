@if ($banners->isNotEmpty())
    <div class="relative overflow-hidden">
        <!-- Slider Wrapper -->
        <div class="flex transition-transform duration-700 ease-in-out" id="slider-wrapper">
            @foreach ($banners as $banner)
                <div class="min-w-full relative">
                    <img src="{{ asset('images/banner/' . $banner->image) }}" alt="{{ $banner->title }}"
                        class="w-full h-[700px] object-cover">
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button onclick="prevSlide()"
            class="absolute top-1/2 left-5 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75 transition duration-300">
            &#10094; <!-- Left arrow -->
        </button>
        <button onclick="nextSlide()"
            class="absolute top-1/2 right-5 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75 transition duration-300">
            &#10095; <!-- Right arrow -->
        </button>

        <!-- Pagination -->
        <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach ($banners as $index => $banner)
                <button onclick="goToSlide({{ $index }})"
                    class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-500 transition duration-300"></button>
            @endforeach
        </div>
    </div>
@else
    <p class="text-gray-500">No banners available.</p>
@endif

<style>
    /* Animation for slider */
    .animate-slide {
        transition: transform 0.7s ease-in-out;
    }
</style>

<script>
    let currentSlide = 0;
    const totalSlides = {{ $banners->count() }};
    const sliderWrapper = document.getElementById('slider-wrapper');

    function showSlide(index) {
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }
        const offset = -currentSlide * 100;
        sliderWrapper.style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(index) {
        showSlide(index);
    }

    // Auto slide
    setInterval(nextSlide, 5000);
</script>
