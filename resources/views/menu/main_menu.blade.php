<!-- resources/views/menu/main_menu.blade.php -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview" role="menu">
        @foreach ($menuItems as $menuItem)
            @php
                // $isActive = request()->is($menuItem->url) || request()->is($menuItem->url . '/*');
                // // Check if any child is active if this is a parent
                // if (!$isActive && $menuItem->children->count()) {
                //     $isActive = $menuItem->children->contains(function ($child) {
                //         return request()->is($child->url) || request()->is($child->url . '/*');
                //     });
                // }
                $isActive = checkActiveMenu($menuItem);
            @endphp

            <li class="nav-item @if ($isActive) menu-open @endif">
                @if (count($menuItem->children) > 0)
                    @php($url = '#')
                @else
                    @php($url = url($menuItem->url))
                @endif
                <a class="nav-link @if ($isActive) active @endif" href="{{ $url }}">
                    <i class="nav-icon fas fa-{{ $menuItem->icon }}"></i>
                    <p>{{ $menuItem->name }}
                        @if (count($menuItem->children))
                            <i class="right fas fa-angle-left"></i>
                        @endif
                    </p>
                </a>

                <!-- {{-- Check for children (sub-menus) and include a sub-menu partial if needed --}} -->
                @if (count($menuItem->children))
                    @include('menu.submenu', ['menus' => $menuItem->children,'level'=>1])
                @endif
            </li>
        @endforeach
    </ul>
</nav>
