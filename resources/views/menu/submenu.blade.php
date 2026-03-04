<!-- resources/views/menu/submenu.blade.php -->
<ul class="nav nav-treeview">
    @foreach ($menus as $menu)
        <li class="nav-item">
            @if (count($menu->children) > 0)
                @php($url = "#")
            @else
                @php($url = url($menu->url))
            @endif
            <a href="{{ $url }}" class="nav-link">
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
