<x-layout-site>
    <x-slot:title>
        Tất cả bài viết
    </x-slot:title>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb với thiết kế tối giản -->
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
                    <span class="text-gray-800 font-medium">Tất cả bài viết</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-12 gap-8">
            <!-- Sidebar được cải thiện -->
            <div class="col-span-12 lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Danh mục chủ đề</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('site.post') }}"
                                class="block px-4 py-2 rounded-lg {{ !request()->route('slug') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }} transition-all">
                                Tất cả bài viết
                            </a>
                        </li>
                        @foreach ($topics as $topic)
                            <li>
                                <a href="{{ route('site.post.slug', ['slug' => $topic->slug]) }}"
                                    class="block px-4 py-2 rounded-lg {{ request()->route('slug') == $topic->slug ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }} transition-all">
                                    {{ $topic->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Grid bài viết được cải thiện -->
            <div class="col-span-12 lg:col-span-9 space-y-8">
                @foreach ($posts as $post)
                    <article
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row">
                            <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                                class="md:w-1/3 relative overflow-hidden">
                                <img class="w-full h-64 md:h-full object-cover transform hover:scale-105 transition-transform duration-300"
                                    src="{{ asset('images/posts/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                            </a>
                            <div class="md:w-2/3 p-6 flex flex-col">
                                <div class="flex-1">
                                    <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                                        class="block mb-4">
                                        <h2
                                            class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition-colors line-clamp-2">
                                            {{ $post->title }}
                                        </h2>
                                    </a>
                                    <p class="text-gray-600 line-clamp-3 mb-4">
                                        {{ $post->content }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <a href="#"
                                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $post->author->name ?? 'Võ Đức Thuận' }}
                                        </a>
                                    </div>
                                    <span class="text-gray-300">•</span>
                                    <time class="text-sm text-gray-500">
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Phân trang được cải thiện -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</x-layout-site>
