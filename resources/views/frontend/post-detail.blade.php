<x-layout-site>
    <x-slot:title>
        Chi tiết bài viết
    </x-slot:title>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb cải tiến -->
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
                    <a href="{{ route('site.post') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">
                        Bài viết
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </li>
                <li>
                    <span class="text-gray-800 font-medium">{{ $post->title }}</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-12 gap-8">
            <!-- Nội dung chính (8 cột) -->
            <div class="col-span-12 lg:col-span-8">
                <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Header bài viết -->
                    <div class="p-6 pb-0">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $post->author->name ?? 'Võ Đức Thuận' }}
                                </a>
                            </div>
                            <span class="text-gray-300">•</span>
                            <time class="text-sm text-gray-500">
                                {{ $post->created_at->format('d/m/Y') }}
                            </time>
                        </div>
                    </div>

                    <!-- Ảnh thumbnail -->
                    <div class="relative h-96 mb-6">
                        <img src="{{ asset('images/posts/' . $post->thumbnail) }}" alt="{{ $post->title }}"
                            class="absolute w-full h-full object-cover">
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="px-6 pb-6">
                        <div class="prose prose-indigo max-w-none">
                            {!! nl2br(e($post->description)) !!}
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ url()->previous() }}"
                                class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar bài viết liên quan (4 cột) -->
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Bài viết liên quan</h2>
                    <div class="space-y-6">
                        @foreach ($relatedPosts as $relatedPost)
                            <article class="group">
                                <a href="{{ route('site.post.detail', ['slug' => $relatedPost->slug]) }}"
                                    class="block relative aspect-video rounded-lg overflow-hidden mb-3">
                                    <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300"
                                        src="{{ asset('images/posts/' . $relatedPost->thumbnail) }}"
                                        alt="{{ $relatedPost->title }}">
                                </a>
                                <div>
                                    <h3
                                        class="font-medium text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 mb-2">
                                        <a href="{{ route('site.post.detail', ['slug' => $relatedPost->slug]) }}">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                                        {{ $relatedPost->content }}
                                    </p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <time>{{ $relatedPost->created_at->format('d/m/Y') }}</time>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-site>
