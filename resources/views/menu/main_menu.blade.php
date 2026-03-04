<!-- resources/views/menu/main_menu.blade.php -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($menuItems as $menuItem)
            <li class="nav-item">
                @if (count($menuItem->children) > 0)
                    @php($url = '#')
                @else
                    @php($url = url($menuItem->url))
                @endif
                <a href="{{ $url }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>{{ $menuItem->name }}
                        @if (count($menuItem->children))
                            <i class="right fas fa-angle-left"></i>
                        @endif
                    </p>
                </a>

                <!-- {{-- Check for children (sub-menus) and include a sub-menu partial if needed --}} -->
                @if (count($menuItem->children))
                    @include('menu.submenu', ['menus' => $menuItem->children])
                @endif
            </li>
        @endforeach
    </ul>
</nav>
