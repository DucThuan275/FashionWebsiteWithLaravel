@if ($category_list != null)
    @foreach ($category_list as $item)
        <li>
            <a href="{{ route('site.product.category', ['slug' => $item->slug]) }}">
                {{ $item->name }}
            </a>
        </li>
    @endforeach
@endif
