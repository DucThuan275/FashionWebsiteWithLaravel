<nav class="flex justify-between items-center">
    <ul class="hidden md:flex space-x-6">
        @foreach ($menus as $menuitem)
            <x-sub-main-menu :menuitem="$menuitem" />
        @endforeach
    </ul>
    <div class="md:hidden visible text-white">
        <i class="fa-solid fa-bars-staggered"></i>
    </div>
</nav>
