@if ($posts->isNotEmpty())
    <div class="container mx-auto mb-5">
        <h1 class="font-bold text-3xl uppercase mb-4 text-center">Bài viết mới nhất</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($posts as $post)
                <div class="rounded overflow-hidden flex flex-col border">
                    <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}">
                        <img class="w-full h-64 object-cover" src="{{ asset('images/posts/' . $post->thumbnail) }}"
                            alt="{{ $post->title }}">
                    </a>
                    <div class="relative -mt-10 px-8 pt-5 pb-10 bg-white shadow-lg">
                        <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                            class="font-semibold text-lg inline-block hover:text-indigo-600 transition duration-500 ease-in-out mb-2">
                            {{ $post->title }}
                        </a>
                        <p class="text-gray-500 text-sm">
                            {{ $post->content }}
                        </p>
                        <p class="mt-5 text-gray-600 text-xs">
                            By
                            <a href="#" class="text-xs text-indigo-600 transition duration-500 ease-in-out">
                                {{ $post->author->name ?? 'Võ Đức Thuận' }}
                            </a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p class="text-gray-500 text-center">Không có bài viết mới nào.</p>
@endif
