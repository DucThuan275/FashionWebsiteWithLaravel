@if ($menus->isNotEmpty())
    <div>
        <h3 class="text-xl font-bold text-white mb-4">Menu Footer</h3>
        <ul class="space-y-2">
            @foreach ($menus as $menu)
                <li>
                    <a href="{{ url($menu->link) }}"
                        class="nav-link text-gray-700 dark:text-gray-200 hover:text-indigo-800">
                        {{ $menu->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <p class="text-gray-500">No footer menus available.</p>
@endif
