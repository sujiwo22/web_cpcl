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
            $icon_show = $menu->icon==null?'circle':$menu->icon;
            $level_now=$level+1;
            $mg_cls=$level*2;
        @endphp

        <li class="nav-item @if($isActive) menu-open @endif">
            @if (count($menu->children) > 0)
                @php($url = '#')
            @else
                @php($url = url($menu->url))
            @endif
            <a class="ml-{{ $mg_cls }} nav-link @if($isActive) active @endif" href="{{ $url }}">
                <i class="fas fa-{{ $icon_show }} nav-icon"></i>
                <p style="margin-left: 3px;">{{ $menu->name }}
                    @if (count($menu->children))
                        <i class="right fas fa-angle-left"></i>
                    @endif
                </p>
            </a>
            @if (count($menu->children))
                @include('menu.submenu', ['menus' => $menu->children,'level'=>$level_now])
            @endif
        </li>
    @endforeach
</ul>
