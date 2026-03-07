<!-- resources/views/menu/submenu.blade.php -->
<ul class="nav nav-treeview">
    @foreach ($menus as $menu)
        @php
            $isActive = request()->is($menu->url) || request()->is($menu->url . '/*');
            // Check if any child is active if this is a parent
            if (!$isActive && $menu->children->count()) {
                $isActive = $menu->children->contains(function ($child) {
                    return request()->is($child->url) || request()->is($child->url . '/*');
                });
            }
        @endphp

        <li class="nav-item @if($isActive) menu-open @endif">
            @if (count($menu->children) > 0)
                @php($url = '#')
            @else
                @php($url = url($menu->url))
            @endif
            <a class="nav-link @if($isActive) active @endif" href="{{ $url }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ $menu->name }}
                    @if (count($menu->children))
                        <i class="right fas fa-angle-left"></i>
                    @endif
                </p>
            </a>
            @if (count($menu->children))
                @include('menu.submenu', ['menus' => $menu->children])
            @endif
        </li>
    @endforeach
</ul>
