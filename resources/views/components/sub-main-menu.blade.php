@if (count($menus) > 0)
    <li class="relative group">
        <!-- Main menu item -->
        <a href="{{ url($menu->link) }}"
            class="flex items-center space-x-1 px-4 py-2 text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 font-medium transition-colors duration-200">
            <span>{{ $menu->name }}</span>
            <!-- Dropdown arrow -->
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </a>

        <!-- Dropdown menu -->
        <ul
            class="absolute left-0 z-20 w-48 py-2 mt-1
                   invisible group-hover:visible opacity-0 group-hover:opacity-100
                   transform scale-95 group-hover:scale-100
                   transition-all duration-200 ease-in-out
                   bg-white dark:bg-gray-800
                   shadow-lg rounded-lg
                   border border-gray-100 dark:border-gray-700">
            @foreach ($menus as $item)
                <li>
                    <a href="{{ url($item->link) }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200
                              hover:bg-indigo-50 dark:hover:bg-gray-700
                              hover:text-indigo-600 dark:hover:text-indigo-400
                              transition-colors duration-200">
                        {{ $item->name }}
                    </a>
                </li>
            @endforeach

            <!-- Decorative arrow -->
            <div
                class="absolute -top-1 left-5 w-2 h-2 rotate-45
                        bg-white dark:bg-gray-800
                        border-l border-t border-gray-100 dark:border-gray-700">
            </div>
        </ul>
    </li>
@else
    <li>
        <a href="{{ url($menu->link) }}"
            class="px-4 py-2 text-gray-700 dark:text-gray-200
                  hover:text-indigo-500 dark:hover:text-indigo-400
                  font-medium transition-colors duration-200">
            {{ $menu->name }}
        </a>
    </li>
@endif

<!-- Add this CSS to your stylesheet -->
<style>
    /* Prevent dropdown from closing when moving cursor to it */
    .group:hover>ul {
        pointer-events: auto;
    }

    .group>ul {
        pointer-events: none;
    }
</style>
