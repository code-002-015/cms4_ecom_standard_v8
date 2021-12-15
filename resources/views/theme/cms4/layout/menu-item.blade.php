@php $page = $item->page; @endphp
@if (!empty($page) && $item->is_page_type() && $page->is_published())
    <li class="menu-item @if(url()->current() == $page->get_url() || ($page->id == 1 && url()->current() == env('APP_URL'))) current @endif @if($item->has_sub_menus()) sub-menu @endif">
        <a href="{{$page->get_url()}}" class="@if($page->get_url() == env('APP_URL').'/contact-us')) button button-border rounded-pill @else menu-link @endif">
            <div>
                @if (!empty($page->label))
                    {{ $page->label }} 
                @else
                    {{ $page->name }} 
                @endif
            </div>
        </a>
        @if ($item->has_sub_menus())
            <ul>
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.'.env('THEME_FOLDER').'.layout.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>
@elseif ($item->is_external_type())
    <li class="menu-item" >
        <a href="{{ $item->uri }}" class="menu-link" target="{{ $item->target }}"><div>{{ $item->label }}</div></a>
        @if ($item->has_sub_menus())
            <ul>
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.'.env('THEME_FOLDER').'.layout.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>
@endif