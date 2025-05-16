<section class="container mx-auto py-12 px-6">
    <h1 class="font-bold text-3xl uppercase mb-4 text-center">
        New Arrivals
    </h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <x-product-card :productitem="$product" />
        @endforeach
    </div>
</section>
